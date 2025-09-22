<?php

use Illuminate\Support\Facades\Route;
use Modules\Leave\Http\Controllers\Tenant\LeaveApplicationController;
use Modules\Leave\Http\Controllers\Tenant\LeaveTypeController;

//Leave Management routes
Route::get('leave-applications/leave-balance', [LeaveApplicationController::class, 'leaveBalanceReport'])
    ->name('leave-applications.leave-balance');
// Only admin and HR managers can manage leave types and generate reports
Route::middleware(['role:admin,hr_manager'])->group(function () {

    Route::get('leave-applications/report', [LeaveApplicationController::class, 'report'])
        ->name('leave-applications.report');

    Route::resource('leave-types', LeaveTypeController::class);
    Route::post('leave-applications/{leave_application}/approve', [LeaveApplicationController::class, 'approve'])
        ->name('leave-applications.approve');
    Route::post('leave-applications/{leave_application}/reject', [LeaveApplicationController::class, 'reject'])
        ->name('leave-applications.reject');
    Route::post('leave-applications/{leave_application}/update-status', [LeaveApplicationController::class, 'updateStatus'])
        ->name('leave-applications.update-status');
});
Route::resource('leave-applications', LeaveApplicationController::class)->only(['index', 'show', 'create', 'store']);

