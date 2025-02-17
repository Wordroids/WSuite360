<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $IsAdmin = auth()->user()->hasRole('admin');
        $IsProjectManager = auth()->user()->hasRole('project_manager');

        if ($IsAdmin) {
            $tasks = Task::with('project','assignedEmployee')->get();
        } elseif ($IsProjectManager) {
            $tasks = Task::with('project', 'assignedTo')->whereHas('project', function ($query) {
                $query->where('manager_id', auth()->id());
            })->get();
        } else {
            $tasks = Task::with('project', 'assignedTo')->where('assigned_to', auth()->id())->get();
        }

        
        return view('pages.tasks.index', compact('tasks'));
    }

    public function create(Project $project_id = null)
    {
        $project = $project_id; // List of projects
        $allUsers = User::all();

        return view('pages.tasks.create', compact('project', 'allUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);


        $task = Task::create($request->all());


        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('pages.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $employees = User::whereHas('role', function ($query) {
            $query->where('name', 'employee');
        })->get();

        return view('pages.tasks.edit', compact('task', 'projects', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
}
