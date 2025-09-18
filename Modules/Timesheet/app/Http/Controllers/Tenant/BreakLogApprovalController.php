<?php


namespace Modules\Timesheet\Http\Controllers\Tenant;

use Modules\Timesheet\Models\BreakLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BreakLogApprovalController extends Controller
{
    public function index()
    {
        $breakLogs = BreakLog::where('status', 'pending')->orderBy('date', 'desc')->get();
        return view('timesheet::pages.break_logs.approvals', compact('breakLogs'));
    }

    public function approve(BreakLog $breakLog)
    {
        $breakLog->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Break log approved.');
    }

    public function reject(BreakLog $breakLog, Request $request)
    {
        $request->validate(['reason' => 'required|string|max:255']);
        $breakLog->update(['status' => 'rejected', 'reason' => $request->reason]);

        return redirect()->back()->with('error', 'Break log rejected.');
    }
}
