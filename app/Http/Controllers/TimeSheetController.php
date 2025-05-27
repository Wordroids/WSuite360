<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeLog;
use App\Models\Project;

class TimeSheetController extends Controller
{



    // Calendar View - Displays time logs in a calendar format
    public function calendarView()
    {
        return view('timesheet.calendarView');
    }

    // List View - Displays timesheet entries

    public function listView()
    {
        // Temporary dummy data
        $projects = [
            (object) ['id' => 1, 'name' => 'Dummy Project 1'],
            (object) ['id' => 2, 'name' => 'Dummy Project 2'],
        ];

        $timeLogs = [];

        return view('timesheet.listView', compact('projects', 'timeLogs'));
    }

    // Charts View - Displays time tracking analytics
    public function chartsView()
    {
        $timeLogs = TimeLog::selectRaw('DATE(date) as day, SUM(time_spent) as total_time')
            ->where('employee_id', Auth::id())
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $chartData = [
            'labels' => $timeLogs->pluck('day')->toArray(),
            'data' => $timeLogs->pluck('total_time')->map(fn($t) => round($t / 60, 1))->toArray(),
        ];

        return view('timesheet.chartsView', compact('chartData'));
    }

    // Add time entry form
    public function add()
    {
        $user = Auth::user();
        $projects = $user ? $user->projects : collect();
        return view('timesheet.add', compact('projects'));
    }

    // Store new time log
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'time_spent' => 'required|numeric|min:1',
        ]);

        TimeLog::create([
            'employee_id' => Auth::id(),
            'project_id' => $request->project_id,
            'task_id' => $request->task_id ?? 1, // Default task ID
            'date' => now(),
            'time_spent' => $request->time_spent,
            'billable' => true,
            'status' => 'pending',
        ]);

        return redirect()->route('timesheet.listView')->with('success', 'Time log saved successfully!');
    }

    // View detailed time entries
    public function view()
    {


        return view('timesheet.view');
    }

    //to view the detailed timesheet report
    public function detailedReport()
    {


        return view('timesheet.detailedReport');
    }
    //to view the weekly timesheet report
    public function  weeklyReport()
    {


        return view('timesheet.weeklyReport');
    }
}
