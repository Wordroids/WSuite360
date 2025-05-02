<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    public function index(Task $task)
    {
        return view('pages.tasks.users.index', compact('task'));
    }
}
