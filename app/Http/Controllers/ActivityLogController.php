<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function logs()
    {
        return view('pages.activity_log.logs');
    }
}
