<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department', 'designation'])->active()->paginate(10);
        return view('pages.employees.index', compact('employees'));
    }

    //To Create
    public function create()
    {
        $departments = Department::all();
        return view('pages.employees.create', compact('departments'));
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
            'employee_code' => 'required|string|max:50|unique:employees',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'date_of_joining' => 'required|date',
        ]);

        $designation = Designation::find($validated['designation_id']);
        if ($designation->department_id != $validated['department_id']) {
            return back()->withErrors(['designation_id' => 'Selected designation does not belong to the selected department.']);
        }

        $validated['status'] = 'active';
        $validated['created_by'] = Auth::id();

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('pages.employees.show', compact('employee'));
    }
    //To edit
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('pages.employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('employees')->ignore($employee->id)
            ],
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'date_of_joining' => 'required|date',
        ]);

        $designation = Designation::find($validated['designation_id']);
        if ($designation->department_id != $validated['department_id']) {
            return back()->withErrors(['designation_id' => 'Selected designation does not belong to the selected department.']);
        }

        $validated['updated_by'] = Auth::id();

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }
    //To delete
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function deactivateForm(Employee $employee)
    {
        return view('pages.employees.deactivate', compact('employee'));
    }

    public function deactivate(Request $request, Employee $employee)
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

    public function reactivate(Employee $employee)
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
}
