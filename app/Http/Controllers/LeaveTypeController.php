<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::latest()->paginate(10);
        return view('pages.leave-types.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('pages.leave-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:leave_types',
            'default_entitlement' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        LeaveType::create($validated);

        return redirect()->route('leave-types.index')
            ->with('success', 'Leave type created successfully.');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('pages.leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:leave_types,name,' . $leaveType->id,
            'default_entitlement' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $leaveType->update($validated);

        return redirect()->route('leave-types.index')
            ->with('success', 'Leave type updated successfully.');
    }

    public function destroy(LeaveType $leaveType)
    {
        if ($leaveType->leaveApplications()->exists()) {
            return back()->with('error', 'Cannot delete leave type with associated applications.');
        }

        $leaveType->delete();

        return redirect()->route('leave-types.index')
            ->with('success', 'Leave type deleted successfully.');
    }
}
