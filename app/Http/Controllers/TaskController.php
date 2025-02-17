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
        // Fetch all tasks for Project Managers
        if (auth()->user()->role->name === 'project_manager') {
            $tasks = Task::with(['project', 'assignedEmployee'])->orderBy('start_date', 'asc')->get();
        } 
        // Employees see only assigned tasks
        else {
            $tasks = Task::where('assigned_to', auth()->id())->with(['project'])->orderBy('start_date', 'asc')->get();
        }

        return view('pages.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all(); // List of projects
        $employees = User::whereHas('role', function ($query) {
            $query->where('name', 'employee');
        })->get(); // List of employees

        return view('pages.tasks.create', compact('projects', 'employees'));
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
