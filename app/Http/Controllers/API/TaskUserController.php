<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    public function index(Task $task, Request $request)
    {
        return response()->json([
            'success' => true,
            'users' => $task->users()->paginate(5, ['*'], 'page', $request->page ?? 1)
        ]);
    }

    public function store(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required:exists:users.id'
        ]);

        if(!$task->users()->where('user_id', $request->user_id)->exists()){
            $task->users()->attach($request->user_id, ['role' => 'member']);
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

    public function destroy(Task $task, User $user)
    {
        $task->users()->detach($user);

        return response()->json([
            'success' => true,
            'message' => 'User removed'
        ], 200);
    }
}
