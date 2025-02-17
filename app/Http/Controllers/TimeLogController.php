<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class TimeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all time logs for the logged-in employee
        $timeLogs = TimeLog::where('employee_id', auth()->id())->orderBy('date', 'desc')->get();
        return view('pages.time_logs.index', compact('timeLogs'));
    }



    public function create()
    {
        // Fetch only tasks assigned to the logged-in user
        $tasks = Task::where('assigned_to', auth()->id())->get();
        return view('pages.time_logs.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'date' => 'required|date',
            'time_spent' => 'required|integer|min:1',
            'billable' => 'boolean',
        ]);

        TimeLog::create([
            'employee_id' => auth()->id(),
            'task_id' => $request->task_id,
            'project_id' => Task::find($request->task_id)->project_id,
            'date' => $request->date,
            'time_spent' => $request->time_spent,
            'billable' => $request->billable ?? false,
            'status' => 'pending',
        ]);

        return redirect()->route('time_logs.index')->with('success', 'Time log submitted for approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeLog $timeLog)
    {
        // Prevent employees from updating locked logs
        if ($timeLog->isLocked()) {
            return redirect()->back()->with('error', 'This time log has been approved and cannot be edited.');
        }
    
        // Validation rules
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'time_spent' => 'required|integer|min:1',
            'billable' => 'required|boolean',
        ]);
    
        // Update time log
        $timeLog->update([
            'task_id' => $request->task_id,
            'time_spent' => $request->time_spent,
            'billable' => $request->billable,
        ]);
    
        return redirect()->route('time_logs.index')->with('success', 'Time log updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
