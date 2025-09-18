<?php

use Illuminate\Support\Facades\Route;
use Modules\Timesheet\Http\Controllers\Tenant\TimesheetController;
use Modules\Timesheet\Http\Controllers\Tenant\BreakLogApprovalController;
use Modules\Timesheet\Http\Controllers\Tenant\TimeLogApprovalController;
use Modules\Timesheet\Http\Controllers\Tenant\TimeLogController;
use Modules\Timesheet\Http\Controllers\Tenant\BreakLogController;
use Modules\Timesheet\Http\Controllers\Tenant\TimeEntryApprovalController;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('timesheets', TimesheetController::class)->names('timesheet');
});

Route::middleware('auth')->group(function () {
    // Timesheet
    Route::get('/listView', [TimeSheetController::class, 'listView'])->name('timesheet.listView');
    Route::get('/calendarView', [TimeSheetController::class, 'calendarView'])->name('timesheet.calendarView');
    Route::get('/add', [TimeSheetController::class, 'add'])->name('timesheet.add');
    Route::get('/edit', [TimeSheetController::class, 'edit'])->name('timesheet.edit');
    Route::get('/view', [TimeSheetController::class, 'view'])->name('timesheet.view');
    Route::get('/chartsView', [TimeSheetController::class, 'chartsView'])->name('timesheet.chartsView');
    Route::get('/detailedReport', [TimeSheetController::class, 'detailedReport'])->name('timesheet.detailedReport');
    Route::get('/weeklyReport', [TimeSheetController::class, 'weeklyReport'])->name('timesheet.weeklyReport');

    // Time Log Approvals

    Route::get('index', [TimeEntryApprovalController::class, 'index'])->name('pages.time_entry_approval.index');
    Route::get('time_logs/approvals', [TimeLogApprovalController::class, 'index'])->name('time_logs.approvals');
    Route::post('time_logs/{timeLog}/approve', [TimeLogApprovalController::class, 'approve'])->name('time_logs.approve');
    Route::post('time_logs/{timeLog}/reject', [TimeLogApprovalController::class, 'reject'])->name('time_logs.reject');
    Route::get('/pending', [TimeEntryApprovalController::class, 'pending'])->name('pages.time_entry_approval.pending');
    Route::get('/approved', [TimeEntryApprovalController::class, 'approved'])->name('pages.time_entry_approval.approved');
    Route::get('/rejected', [TimeEntryApprovalController::class, 'rejected'])->name('pages.time_entry_approval.rejected');

    // Break Log Approvals
    Route::get('break_logs/approvals', [BreakLogApprovalController::class, 'index'])->name('break_logs.approvals');
    Route::post('break_logs/{breakLog}/approve', [BreakLogApprovalController::class, 'approve'])->name('break_logs.approve');
    Route::post('break_logs/{breakLog}/reject', [BreakLogApprovalController::class, 'reject'])->name('break_logs.reject');

    // Manager Dashboard
    Route::get('dashboard/manager', [TimeLogApprovalController::class, 'dashboard'])->name('dashboard.manager');
});

// Employee Routes (Time Logs & Break Logs)
Route::middleware('role:developer')->group(function () {
    Route::resource('time_logs', TimeLogController::class)->except(['destroy']);
    Route::resource('break_logs', BreakLogController::class)->except(['destroy']);
});
