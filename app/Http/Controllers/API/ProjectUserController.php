<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function index(Project $project)
    {
        return response()->json([
            'success' => true,
            'users' => $project->users
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required:exists:users.id'
        ]);

        if(!$project->users()->where('user_id', $request->user_id)->exists()){
            $project->users()->attach($request->user_id, ['role' => 'member']);
            return response()->json([
                'success' => true,
                'message' => 'User added'
            ], 201);
        } else{
            return response()->json([
                'success' => false,
                'message' => 'User already added'
            ], 422);
        }

    }

    public function destroy(Project $project, User $user)
    {
        $project->users()->detach($user);

        return response()->json([
            'success' => true,
            'message' => 'User removed'
        ], 200);
    }
}
