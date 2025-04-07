<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function index(Project $project)
    {
        dd($project->users);
        // display project->users in the UI
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'user_id'
        ]);

        $project->users()->attach($request->user_id);
        // redirect back to 'index'
    }

    public function destroy(Project $project, User $user)
    {
        $project->users()->detach($user);
        // redirect back to 'index'
    }
}
