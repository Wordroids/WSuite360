<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimeSheetController extends Controller
{

    //List view
    public function listView()
    {

        return view('timesheet.listView');
    }
    //Calendar view
    public function calendarView()
    {

        return view('timesheet.calendarView');
    }


    //Add time entries
    public function add()
    {

        return view('timesheet.add');
    }

    //Edit time entries
    public function edit()
    {

        return view('timesheet.edit');
    }


    //View time entries
    public function view()
    {

        return view('timesheet.view');
    }
}
