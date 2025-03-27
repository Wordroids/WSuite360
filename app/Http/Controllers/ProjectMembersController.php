<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProjectMembers;
use App\Models\Project;

class ProjectMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectMembers = ProjectMembers::paginate(10);
        return view('project_members.index', compact('projectMembers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all(); // Get all projects
        return view('project_members.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'group' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:project_members',
            'project_id' => 'required|exists:projects,id',

        ]);


        ProjectMembers::create([
            'name' => $request->name,
            'role' => $request->role,
            'group' => $request->group,
            'email' => $request->email,
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
        ]);


        return redirect()->route('project_members.index')->with('success', 'Poject member created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectMembers $projectMembers) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $projectMember = ProjectMembers::findOrFail($id);
        $projects = Project::all();
        return view('project_members.edit', compact('projectMember', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'group' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:project_members,email,' . $id, // Allow the email to be the same as the current one
        ]);

        $projectMember = ProjectMembers::findOrFail($id);


        $projectMember->update($request->all());


        return redirect()->route('project_members.index')->with('success', 'Project member updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $projectMember = ProjectMembers::findOrFail($id);
        $projectMember->delete();


        return redirect()->route('project_members.index')->with('success', 'Project member deleted successfully!');
    }
}
