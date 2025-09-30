<?php

namespace Modules\Employees\Http\Controllers\Tenant;

use Modules\Timesheet\Models\TimeLog;
use Modules\Timesheet\Models\BreakLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Fetch Logs for the Logged-in Employee
        $timeLogs = TimeLog::where('employee_id', $userId)->orderBy('date', 'desc')->get();
        $breakLogs = BreakLog::where('employee_id', $userId)->orderBy('date', 'desc')->get();

        return view('employees::pages.employee.dashboard', compact('timeLogs', 'breakLogs'));
    }
}
