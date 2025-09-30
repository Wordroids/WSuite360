<?php

namespace Modules\Tasks\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Modules\Tasks\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    public function index(Task $task)
    {
        $availableUsers = User::whereNotIn('id', $task->members()->pluck('users.id'))->get();
        return view('tasks::pages.tasks.users.index', [
            'task' => $task,
            'availableUsers' => $availableUsers
        ]);
    }

    public function getTaskUsers(Task $task, Request $request)
    {
        $users = $task->members()->paginate(5, ['*'], 'page', $request->page ?? 1);
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function getAvailableUsers(Task $task, Request $request)
    {
        $search = $request->search ?? '';

        $users = User::whereNotIn('id', $task->members()->pluck('users.id'))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    //create
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:member,developer,reviewer'
        ]);

        if ($task->members()->where('user_id', $request->user_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'User already added to this task'
            ], 422);
        }

        $task->members()->attach($request->user_id, ['role' => $request->role]);

        return response()->json([
            'success' => true,
            'message' => 'User added to task successfully'
        ], 201);
    }

    //edit
    public function update(Request $request, Task $task, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:member,developer,reviewer'
        ]);

        if (!$task->members()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'User not found in this task'
            ], 404);
        }

        $task->members()->updateExistingPivot($user->id, [
            'role' => $request->role,
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User role updated successfully'
        ]);
    }

    //delete
    public function destroy(Task $task, User $user)
    {
        $task->members()->detach($user);

        return response()->json([
            'success' => true,
            'message' => 'User removed from task successfully'
        ]);
    }
}
