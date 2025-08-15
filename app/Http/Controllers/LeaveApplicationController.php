<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
