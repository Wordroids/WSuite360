<?php
namespace App\Http\Controllers;

use App\Models\BreakLog;
use Illuminate\Http\Request;

class BreakLogController extends Controller
{
    public function index()
    {
        // Get all break logs for the logged-in employee
        $breakLogs = BreakLog::where('employee_id', auth()->id())->orderBy('date', 'desc')->get();
        return view('pages.break_logs.index', compact('breakLogs'));
    }

    public function create()
    {
        return view('pages.break_logs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'break_time' => 'required|integer|min:1',
        ]);

        BreakLog::create([
            'employee_id' => auth()->id(),
            'date' => $request->date,
            'break_time' => $request->break_time,
            'status' => 'pending',
        ]);

        return redirect()->route('break_logs.index')->with('success', 'Break log submitted for approval.');
    }

    public function edit(BreakLog $breakLog)
    {
        // Ensure only the owner can edit & only pending logs can be edited
        if ($breakLog->employee_id !== auth()->id() || $breakLog->status !== 'pending') {
            abort(403, 'Unauthorized access.');
        }

        return view('pages.break_logs.edit', compact('breakLog'));
    }

    public function update(Request $request, BreakLog $breakLog)
    {
        if ($breakLog->employee_id !== auth()->id() || $breakLog->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'date' => 'required|date',
            'break_time' => 'required|integer|min:1',
        ]);

        $breakLog->update([
            'date' => $request->date,
            'break_time' => $request->break_time,
        ]);

        return redirect()->route('break_logs.index')->with('success', 'Break log updated successfully.');
    }
}
