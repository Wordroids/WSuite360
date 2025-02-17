<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Client;
use App\Models\ProjectMembers;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admins can see all projects
        if ($user->role->name === 'admin') {
            $projects = Project::withCount('members')->with('client')->latest()->paginate(10);
        }
        // Project Managers can only see assigned projects
        else if ($user->role->name === 'project_manager') {
            $projects = Project::whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->withCount('members')->with('client')->latest()->paginate(10);
        }
        // Other roles see nothing
        else {
            $projects = collect(); // Empty collection
        }
        return view('pages.projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('pages.projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_id'   => 'required|exists:clients,id',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        // Fetch assigned employees along with their role
        $assignedEmployees = ProjectMembers::where('project_id', $project->id)
            ->with(['user' => function ($query) {
                $query->with('role'); // Load the user's role
            }])->get();

        // Separate Project Managers, Developers, and Employees
        $projectManagers = $assignedEmployees->filter(function ($member) {
            return optional($member->user->role)->name === 'project_manager';
        });

        $developers = $assignedEmployees->filter(function ($member) {
            return optional($member->user->role)->name === 'developer';
        });

        $employees = $assignedEmployees->filter(function ($member) {
            return optional($member->user->role)->name === 'employee';
        });


        // Get unassigned employees (role: employee)
        $unassignedEmployees = User::whereNotIn('id', $assignedEmployees->pluck('user_id'))->get();

        return view('pages.projects.show', compact('project', 'employees', 'developers', 'projectManagers', 'unassignedEmployees'));
    }

    public function edit(Project $project)
    {
        $clients = Client::all();
        return view('pages.projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }

    public function assignEmployee(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if employee is already assigned
        $exists = ProjectMembers::where('project_id', $project->id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Employee is already assigned.');
        }

        ProjectMembers::create([
            'project_id' => $project->id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->back()->with('success', 'Employee assigned successfully.');
    }
}
