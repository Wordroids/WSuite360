<?php

namespace App\Http\Controllers;

use App\Models\BreakLog;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Fetch Logs for the Logged-in Employee
        $timeLogs = TimeLog::where('employee_id', $userId)->orderBy('date', 'desc')->get();
        $breakLogs = BreakLog::where('employee_id', $userId)->orderBy('date', 'desc')->get();

        return view('pages.employee.dashboard', compact('timeLogs', 'breakLogs'));
    }
}
