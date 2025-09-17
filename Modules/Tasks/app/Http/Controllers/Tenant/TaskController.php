<?php

namespace Modules\Tasks\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Modules\Tasks\Models\Task;
use App\Models\Project;
use App\Models\ProjectMembers;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->role->name === 'admin';
        $isProjectManager = $user->role->name === 'project_manager';

        $projectId = $request->input('project_id');
        $projects = Project::all();

        if ($isAdmin) {
            // Admins see all tasks
            $tasksQuery = Task::query();
        } elseif ($isProjectManager) {
            // Project Managers only see tasks from projects they are assigned to
            $tasksQuery = Task::whereHas('project.members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } else {
            // Employees & Developers see only their assigned tasks
            $tasksQuery = Task::where('assigned_to', $user->id);
        }
        // Filter by selected project if provided
        if ($projectId) {
            $tasksQuery->where('project_id', $projectId);
        }

        $tasks = $tasksQuery->with(['project', 'assignedEmployee'])->latest()->paginate(10);

        return view('tasks::pages.tasks.index', compact('tasks', 'projects', 'projectId'));
    }

    public function create()
    {
        $projects = Project::all();

        return view('tasks::pages.tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);


        $task = Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('members');
        return view('tasks::pages.tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $projects = Project::all();

        return view('tasks::pages.tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|in:to_do,in_progress,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $task = Task::findOrFail($id);

        $task->update([
            'title' => $request->input('title'),
            'project_id' => $request->input('project_id'),
            'status' => $request->input('status'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // to delete
    public function destroy($id)
    {
        $tasks = Task::findOrFail($id);
        $tasks->delete();


        return redirect()->route('tasks.index')->with('success', 'Tasks deleted successfully!');
    }
}
