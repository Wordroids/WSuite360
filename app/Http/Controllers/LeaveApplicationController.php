<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LeaveApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveApplication::with(['employee', 'leaveType']);

        // Apply filters only if they are present in the request
        if ($request->has('employee_id') && $request->employee_id != '') {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->has('leave_type_id') && $request->leave_type_id != '') {
            $query->where('leave_type_id', $request->leave_type_id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $leaveApplications = $query->latest()->paginate(10);

        $employees = Employee::active()->get();
        $leaveTypes = LeaveType::all();

        return view('pages.leave-applications.index', [
            'leaveApplications' => $leaveApplications,
            'employees' => $employees,
            'leaveTypes' => $leaveTypes
        ]);
    }

    //to create
    public function create()
    {
        $leaveTypes = LeaveType::where('is_active', true)->get();
        $employees = Employee::active()->get();

        return view('pages.leave-applications.create', compact('leaveTypes', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);

        // Calculate days requested
        $start = new \DateTime($validated['start_date']);
        $end = new \DateTime($validated['end_date']);
        $daysRequested = $start->diff($end)->days + 1;

        $validated['days_requested'] = $daysRequested;
        $validated['status'] = 'pending';

        LeaveApplication::create($validated);

        return redirect()->route('leave-applications.index')
            ->with('success', 'Leave application submitted successfully.');
    }

    public function show(LeaveApplication $leaveApplication)
    {
        return view('pages.leave-applications.show', compact('leaveApplication'));
    }

    public function approve(LeaveApplication $leaveApplication)
    {
        // to check if user has admin or hr_manager role
        if (!in_array(auth()->user()->role->name, ['admin', 'hr_manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $leaveApplication->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Leave application approved.');
    }

    public function reject(Request $request, LeaveApplication $leaveApplication)
    {
        // to check if user has admin or hr_manager role
        if (!in_array(auth()->user()->role->name, ['admin', 'hr_manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $leaveApplication->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Leave application rejected.');
    }



    public function updateStatus(Request $request, LeaveApplication $leaveApplication)
    {
        if (!in_array(auth()->user()->role->name, ['admin', 'hr_manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'reason' => 'nullable|string|max:500'
        ]);

        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === 'approved') {
            $updateData['approved_by'] = Auth::id();
            $updateData['approved_at'] = now();
            $updateData['rejection_reason'] = null;
            $updateData['rejected_by'] = null;
            $updateData['rejected_at'] = null;
        } elseif ($validated['status'] === 'rejected') {
            $updateData['rejection_reason'] = $validated['reason'];
            $updateData['rejected_by'] = Auth::id();
            $updateData['rejected_at'] = now();
            $updateData['approved_by'] = null;
            $updateData['approved_at'] = null;
        } else {

            $updateData['approved_by'] = null;
            $updateData['approved_at'] = null;
            $updateData['rejection_reason'] = null;
            $updateData['rejected_by'] = null;
            $updateData['rejected_at'] = null;
        }

        $leaveApplication->update($updateData);

        return back()->with('success', 'Leave application status updated.');
    }

    public function report(Request $request)
    {
        $query = LeaveApplication::with(['employee', 'leaveType', 'employee.department'])
            ->when($request->has('department_id') && $request->department_id != '', function ($q) use ($request) {
                $q->whereHas('employee', function ($employeeQuery) use ($request) {
                    $employeeQuery->where('department_id', $request->department_id);
                });
            })
            ->when($request->has('leave_type_id') && $request->leave_type_id != '', function ($q) use ($request) {
                $q->where('leave_type_id', $request->leave_type_id);
            })
            ->when($request->has('status') && $request->status != '', function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->has('start_date') && $request->start_date != '', function ($q) use ($request) {
                $q->whereDate('start_date', '>=', $request->start_date);
            })
            ->when($request->has('end_date') && $request->end_date != '', function ($q) use ($request) {
                $q->whereDate('end_date', '<=', $request->end_date);
            });

        $leaveApplications = $query->latest()->get();

        $departments = Department::all();
        $leaveTypes = LeaveType::all();

        // PDF Export
        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = PDF::loadView('pages.leave-applications.report-pdf', [
                'leaveApplications' => $leaveApplications,
                'filters' => $request->all(),
                'departmentName' => $request->department_id ? Department::find($request->department_id)->name : 'All',
                'leaveTypeName' => $request->leave_type_id ? LeaveType::find($request->leave_type_id)->name : 'All'
            ]);
            return $pdf->download('leave-history-report-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('pages.leave-applications.report', [
            'leaveApplications' => $leaveApplications,
            'departments' => $departments,
            'leaveTypes' => $leaveTypes,
            'filters' => $request->all()
        ]);
    }

    //to generate leave balance report
    public function leaveBalanceReport(Request $request)
    {
        // Get all active employees with their leave balances
        $query = Employee::with(['department', 'leaveBalances.leaveType'])
            ->active()
            ->withCount(['leaveApplications as total_used_leave' => function ($q) use ($request) {
                $q->where('status', 'approved');

                if ($request->has('leave_type_id') && $request->leave_type_id != '') {
                    $q->where('leave_type_id', $request->leave_type_id);
                }

                if ($request->has('start_date') && $request->start_date != '') {
                    $q->whereDate('start_date', '>=', $request->start_date);
                }

                if ($request->has('end_date') && $request->end_date != '') {
                    $q->whereDate('end_date', '<=', $request->end_date);
                }
            }]);

        // Apply department filter 
        if ($request->has('department_id') && $request->department_id != '') {
            $query->where('department_id', $request->department_id);
        }

        $employees = $query->get()->map(function ($employee) use ($request) {
            // If no leave balances exist, create a default breakdown using leave types
            if ($employee->leaveBalances->isEmpty()) {
                $leaveTypes = LeaveType::all();
                $employee->leave_breakdown = $leaveTypes->map(function ($type) use ($employee, $request) {
                    $usedQuery = $employee->leaveApplications()
                        ->where('leave_type_id', $type->id)
                        ->where('status', 'approved');

                    if ($request->has('start_date') && $request->start_date != '') {
                        $usedQuery->whereDate('start_date', '>=', $request->start_date);
                    }

                    if ($request->has('end_date') && $request->end_date != '') {
                        $usedQuery->whereDate('end_date', '<=', $request->end_date);
                    }

                    $used = $usedQuery->sum('days_requested');

                    return [
                        'leave_type' => $type->name,
                        'allocated' => $type->default_entitlement ?? 0,
                        'used' => $used,
                        'remaining' => ($type->default_entitlement ?? 0) - $used
                    ];
                });
            } else {
                // Calculate leave balances for each leave type
                $employee->leave_breakdown = $employee->leaveBalances->map(function ($balance) use ($employee, $request) {
                    $usedQuery = $employee->leaveApplications()
                        ->where('leave_type_id', $balance->leave_type_id)
                        ->where('status', 'approved');

                    if ($request->has('start_date') && $request->start_date != '') {
                        $usedQuery->whereDate('start_date', '>=', $request->start_date);
                    }

                    if ($request->has('end_date') && $request->end_date != '') {
                        $usedQuery->whereDate('end_date', '<=', $request->end_date);
                    }

                    $used = $usedQuery->sum('days_requested');

                    return [
                        'leave_type' => $balance->leaveType->name,
                        'allocated' => $balance->days,
                        'used' => $used,
                        'remaining' => $balance->days - $used
                    ];
                });
            }

            return $employee;
        });

        $departments = Department::all();
        $leaveTypes = LeaveType::all();

        // PDF Export
        if ($request->has('export') && $request->export == 'pdf') {
            $filters = $request->all();
            $pdf = PDF::loadView('pages.leave-applications.leave-balance-pdf', [
                'employees' => $employees,
                'filters' => $filters,
                'departmentName' => isset($filters['department_id']) && $filters['department_id'] ? Department::find($filters['department_id'])->name : 'All',
                'leaveTypeName' => isset($filters['leave_type_id']) && $filters['leave_type_id'] ? LeaveType::find($filters['leave_type_id'])->name : 'All'
            ]);
            return $pdf->download('leave-balance-report-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('pages.leave-applications.leave-balance', [
            'employees' => $employees,
            'departments' => $departments,
            'leaveTypes' => $leaveTypes,
            'filters' => $request->all()
        ]);
    }
}
