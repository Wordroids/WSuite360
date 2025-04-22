<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function index(Project $project, Request $request)
    {
        return response()->json([
            'success' => true,
            'users' => $project->users()->paginate(5, ['*'], 'page', $request->page ?? 1)
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

    public function update(Project $project, User $user, Request $request)
    {
        request()->validate([
            'role' => 'required|string|max:255'
        ]);

        // Check if user exists in project
        if (!$project->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'User not found in this project'
            ], 404);
        }

        $project->users()->updateExistingPivot($user->id, [
            'role' => $request->role,
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ]);
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
