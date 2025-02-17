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
        $user = auth()->user();
        $IsAdmin = $user->role->name === 'admin';
        $IsProjectManager = $user->role->name === 'project_manager';

        if ($IsAdmin) {
            // Admins see all tasks
            $tasks = Task::with(['project', 'assignedEmployee'])->latest()->paginate(10);

        } else if ($IsProjectManager) {
            // Project Managers only see tasks from projects they are assigned to
            $tasks = Task::whereHas('project.members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['project', 'assignedEmployee'])->latest()->paginate(10);
        } 
        else {
            // Employees & Developers see only their assigned tasks
            $tasks = Task::where('assigned_to', $user->id)
                ->with(['project', 'assignedEmployee'])
                ->latest()
                ->paginate(10);
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
