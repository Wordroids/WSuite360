<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimeEntryApprovalController extends Controller
{
    public function index()
    {
        return view('pages.time_entry_approval.index');
    }
    public function pending()
    {
        return view('pages.time_entry_approval.pending');
    }

    public function approved()
    {
        return view('pages.time_entry_approval.approved');
    }


    public function rejected()
    {
        return view('pages.time_entry_approval.rejected');
    }
}
