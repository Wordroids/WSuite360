<?php

namespace Modules\Timesheet\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TimeEntryApprovalController extends Controller
{
    public function index()
    {
        return view('timesheet::pages.time_entry_approval.index');
    }
    public function pending()
    {
        return view('timesheet::pages.time_entry_approval.pending');
    }

    public function approved()
    {
        return view('timesheet::pages.time_entry_approval.approved');
    }


    public function rejected()
    {
        return view('timesheet::pages.time_entry_approval.rejected');
    }
}
