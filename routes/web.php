<?php

use App\Http\Controllers\BreakLogApprovalController;
use App\Http\Controllers\BreakLogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\TimeLogApprovalController;
use App\Http\Controllers\TimeSheetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route (Only Authenticated Users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Routes Group
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //admin routes
    Route::middleware('role:admin')->group(function () {
        // Company Routes
        Route::resource('companies', CompanyController::class);

        // Clients Routes
        Route::resource('clients', ClientController::class);
    });




    // Employee Routes (Time Logs & Break Logs)
    Route::middleware('role:developer')->group(function () {
        Route::resource('time_logs', TimeLogController::class)->except(['destroy']);
        Route::resource('break_logs', BreakLogController::class)->except(['destroy']);
        Route::get('employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    });


    // Project Manager Routes (Approvals & Manager Dashboard)
    Route::middleware('role:project_manager')->group(function () {

        // Time Log Approvals
        Route::get('time_logs/approvals', [TimeLogApprovalController::class, 'index'])->name('time_logs.approvals');
        Route::post('time_logs/{timeLog}/approve', [TimeLogApprovalController::class, 'approve'])->name('time_logs.approve');
        Route::post('time_logs/{timeLog}/reject', [TimeLogApprovalController::class, 'reject'])->name('time_logs.reject');

        // Break Log Approvals
        Route::get('break_logs/approvals', [BreakLogApprovalController::class, 'index'])->name('break_logs.approvals');
        Route::post('break_logs/{breakLog}/approve', [BreakLogApprovalController::class, 'approve'])->name('break_logs.approve');
        Route::post('break_logs/{breakLog}/reject', [BreakLogApprovalController::class, 'reject'])->name('break_logs.reject');

        // Manager Dashboard
        Route::get('dashboard/manager', [TimeLogApprovalController::class, 'dashboard'])->name('dashboard.manager');
    });

    // Routes For admin and ProjectManger Role
    Route::middleware(['auth', 'role:admin,project_manager'])->group(function () {
        Route::get('tasks/create/{project_id}', [TaskController::class, 'create'])->name('tasks.create');
        Route::resource('tasks', TaskController::class)->except(['create']);
        Route::post('projects/{project}/assign', [ProjectController::class, 'assignEmployee'])->name('projects.assign');
        Route::resource('projects', ProjectController::class);
    });
});

//Timesheet
Route::get('/listView', [TimeSheetController::class, 'listView'])->name('timesheet.listView');
Route::get('/calendarView', [TimeSheetController::class, 'calendarView'])->name('timesheet.calendarView');
Route::get('/add', [TimeSheetController::class, 'add'])->name('timesheet.add');
Route::get('/edit', [TimeSheetController::class, 'edit'])->name('timesheet.edit');
Route::get('/view', [TimeSheetController::class, 'view'])->name('timesheet.view');

// Include Authentication Routes
require __DIR__ . '/auth.php';
