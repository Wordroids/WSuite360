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
        $projects = Project::with('client')->latest()->paginate(10);
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
        // Get assigned employees
        $assignedEmployees = $project->members()->with('user')->get();

        // Get unassigned employees (role: employee)
        $unassignedEmployees = User::whereNotIn('id', $assignedEmployees->pluck('user_id'))->get();

        return view('pages.projects.show', compact('project', 'assignedEmployees', 'unassignedEmployees'));
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
