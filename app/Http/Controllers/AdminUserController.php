<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{

    //Display a listing of users.

    public function index()
    {
        $users = User::all();
        return view('pages.users.index', compact('users'));
    }


    // Show the form for editing a user.

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }


    // Update the user

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }


    // Remove the user

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function show(User $user)
    {
        return view('pages.users.show', compact('user'));
    }
}
