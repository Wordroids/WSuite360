<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $query = EmployeeProfile::with(['department', 'designation', 'user']);
        } elseif ($user->hasRole('project_manager')) {
            $projectIds = $user->managedProjects()->pluck('id');
            $employeeIds = DB::table('project_user')
                ->whereIn('project_id', $projectIds)
                ->pluck('user_id')
                ->toArray();

            $query = EmployeeProfile::with(['department', 'designation', 'user'])
                ->whereIn('user_id', $employeeIds);
        } else {
            // t get the employee profile for the logged-in user
            $employeeProfile = $user->employeeProfile;
            if (!$employeeProfile) {
                abort(403, 'You need to have an employee profile to access this page.');
            }
            return redirect()->route('employees.show', $employeeProfile);
        }
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->has('designation_id') && $request->designation_id) {
            $query->where('designation_id', $request->designation_id);
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $employees = $query->paginate(10);
        $departments = Department::all();
        $designations = Designation::all();

        return view('pages.employees.index', compact('employees', 'departments', 'designations'));
    }

    //To Create
    public function create()
    {
        $departments = Department::all();
        $designations = Designation::all();
        return view('pages.employees.create', compact('departments', 'designations'));
    }

    // To fetch designations
    public function getDesignations($departmentId)
    {
        $designations = Designation::where('department_id', $departmentId)->get();
        return response()->json($designations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // User data
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',

            // EmployeeProfile data
            'employee_code' => 'required|string|max:50|unique:employees,employee_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'date_of_joining' => 'required|date',
        ]);

        $designation = Designation::find($validated['designation_id']);
        if ($designation->department_id != $validated['department_id']) {
            return back()->withErrors(['designation_id' => 'Selected designation does not belong to the selected department.'])->withInput();
        }


        DB::transaction(function () use ($validated) {
            // Create the Core User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $validated['role_id'],
            ]);

            //Create the EmployeeProfile linked to the User
            EmployeeProfile::create([
                'user_id' => $user->id,
                'email' => $validated['email'],
                'employee_code' => $validated['employee_code'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'department_id' => $validated['department_id'],
                'designation_id' => $validated['designation_id'],
                'date_of_joining' => $validated['date_of_joining'],
                'status' => 'active',
                'created_by' => Auth::id(),

            ]);
        });
        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(EmployeeProfile $employee)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return view('pages.employees.show', compact('employee'));
        } elseif ($user->hasRole('project_manager')) {
            $projectIds = $user->managedProjects()->pluck('id');
            $isEmployeeInProjects = DB::table('project_user')
                ->whereIn('project_id', $projectIds)
                ->where('user_id', $employee->user_id) // Check the user_id from the profile
                ->exists();

            if ($isEmployeeInProjects) {
                return view('pages.employees.show', compact('employee'));
            }
            abort(403, 'Access denied. You can only view employees in your projects.');
        } else {
            $userEmployeeProfile = $user->employeeProfile; // Get profile via trait
            if ($userEmployeeProfile && $userEmployeeProfile->id === $employee->id) {
                return view('pages.employees.show', compact('employee'));
            }
            abort(403, 'Access denied. You can only view your own profile.');
        }
    }
    //To edit
    public function edit(EmployeeProfile $employee)
    {
        $departments = Department::all();
        return view('pages.employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, EmployeeProfile $employee)
    {
        $validated = $request->validate([
            // User data
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($employee->user->id)
            ],

            // EmployeeProfile data
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'date_of_joining' => 'required|date',
        ]);
        $designation = Designation::find($validated['designation_id']);
        if ($designation->department_id != $validated['department_id']) {
            return back()->withErrors(['designation_id' => 'Selected designation does not belong to the selected department.'])->withInput();
        }

        DB::transaction(function () use ($validated, $employee) {
            //Update the linked User
            $employee->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            //Update the EmployeeProfile
            $employee->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'department_id' => $validated['department_id'],
                'designation_id' => $validated['designation_id'],
                'date_of_joining' => $validated['date_of_joining'],
                'updated_by' => Auth::id(),
            ]);
        });

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }
    //To delete
    public function destroy(EmployeeProfile $employee)
    {
        DB::transaction(function () use ($employee) {
            $userId = $employee->user_id;
        $employee->delete();
            User::find($userId)->delete(); // Delete the associated user
        });

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function deactivateForm(EmployeeProfile $employee)
    {
        return view('pages.employees.deactivate', compact('employee'));
    }

    public function deactivate(Request $request, EmployeeProfile $employee)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Record status change history
        EmployeeStatusHistory::create([
            'employee_id' => $employee->id,
            'previous_status' => $employee->status,
            'new_status' => 'inactive',
            'reason' => $request->reason,
            'changed_by' => Auth::id(),
        ]);

        $employee->update([
            'status' => 'inactive',
            'inactive_reason' => $request->reason,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee deactivated successfully.');
    }

    public function reactivate(EmployeeProfile $employee)
    {
        // Record status change history
        EmployeeStatusHistory::create([
            'employee_id' => $employee->id,
            'previous_status' => $employee->status,
            'new_status' => 'active',
            'reason' => 'Reactivated by admin',
            'changed_by' => Auth::id(),
        ]);

        $employee->update([
            'status' => 'active',
            'inactive_reason' => null,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee reactivated successfully.');
    }
    public function exportPdf(Request $request)
    {
        $query = EmployeeProfile::with(['department', 'designation']);

        // filters
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('designation_id') && $request->designation_id) {
            $query->where('designation_id', $request->designation_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $employees = $query->get();

        // Load the view
        $pdf = PDF::loadView('pages.employees.report', [
            'employees' => $employees
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('employee_report_' . now()->format('YmdHis') . '.pdf');
    }
}
