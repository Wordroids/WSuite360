<?php

namespace Modules\Projects\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Modules\Projects\Models\Project;

class ProjectUserController extends Controller
{
    public function index(Project $project)
    {
        return view('projects::pages.projects.users.index', compact('project'));
    }
}
