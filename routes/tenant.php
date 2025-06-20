<?php

declare(strict_types=1);

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\API\ProjectUserController as APIProjectUserController;
use App\Http\Controllers\API\UserController as APIUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\BreakLogApprovalController;
use App\Http\Controllers\BreakLogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeEntryApprovalController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\TimeLogApprovalController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\TaskUserController;
use App\Http\Controllers\CompanySettingController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/invoices/{invoice}/preview-pdf', [InvoiceController::class, 'showPDF'])->name('invoice.preview');

    //storage link
    Route::get('/storage-link', function () {
        \Artisan::call('storage:link');
        return 'Storage link created successfully.';
    })->name('storage.link');



    // Dashboard Route (Only Authenticated Users)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Authentication routes
    Route::middleware('guest')->group(function () {


        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');

        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });

    // Authenticated Routes Group
    Route::middleware('auth')->group(function () {

        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Timesheet
        Route::get('/listView', [TimeSheetController::class, 'listView'])->name('timesheet.listView');
        Route::get('/calendarView', [TimeSheetController::class, 'calendarView'])->name('timesheet.calendarView');
        Route::get('/add', [TimeSheetController::class, 'add'])->name('timesheet.add');
        Route::get('/edit', [TimeSheetController::class, 'edit'])->name('timesheet.edit');
        Route::get('/view', [TimeSheetController::class, 'view'])->name('timesheet.view');
        Route::get('/chartsView', [TimeSheetController::class, 'chartsView'])->name('timesheet.chartsView');
        Route::get('/detailedReport', [TimeSheetController::class, 'detailedReport'])->name('timesheet.detailedReport');
        Route::get('/weeklyReport', [TimeSheetController::class, 'weeklyReport'])->name('timesheet.weeklyReport');

        // Admin routes
        Route::middleware('role:admin')->group(function () {

            // Clients Routes
            Route::resource('clients', ClientController::class);
        });

        //Activity log
        Route::get('/logs', [ActivityLogController::class, 'logs'])->name('pages.activity_log.logs');

        //Time Entry Approval
        Route::get('/index', [TimeEntryApprovalController::class, 'index'])->name('pages.time_entry_approval.index');
        Route::get('/pending', [TimeEntryApprovalController::class, 'pending'])->name('pages.time_entry_approval.pending');
        Route::get('/approved', [TimeEntryApprovalController::class, 'approved'])->name('pages.time_entry_approval.approved');
        Route::get('/rejected', [TimeEntryApprovalController::class, 'rejected'])->name('pages.time_entry_approval.rejected');

        // Employee Routes (Time Logs & Break Logs)
        Route::middleware('role:developer')->group(function () {
            Route::resource('time_logs', TimeLogController::class)->except(['destroy']);
            Route::resource('break_logs', BreakLogController::class)->except(['destroy']);
            Route::get('employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
        });

        // Project Manager Routes (Approvals & Manager Dashboard)
        Route::middleware('role:project_manager,admin')->group(function () {

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

            // Project member assingment
            Route::resource('projects.users', ProjectUserController::class)->only(['index', 'store', 'destroy']);
        });


        //user routes
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('users', AdminUserController::class)->except(['create', 'store']);
        });
        Route::get('users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');

        Route::get('/pages/users/index', [AdminUserController::class, 'index'])->name('pages.users.index');


        //Routes for Invoice
        Route::get('/pages/invoice/index', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::get('/viewInvoice', [InvoiceController::class, 'viewInvoice'])->name('invoice.show');
        Route::post('/invoice/store', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::delete('/invoice/{invoice}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
        Route::get('/invoice/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');

        Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'showPdf'])->name('invoices.showPdf');
        Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'downloadPdf'])->name('invoice.download');



        Route::post('/invoice/{invoice}/approve', [InvoiceController::class, 'approve'])->name('invoice.approve');
        Route::post('/invoice/{invoice}/mark-as-sent', [InvoiceController::class, 'markAsSent'])->name('invoice.markAsSent');
        Route::post('/invoices/{invoice}/record-payment', [InvoiceController::class, 'recordPayment'])->name('invoice.recordxPayment');

        Route::get('/invoices/{invoice}/payments/{payment}/receipt', [InvoiceController::class, 'receipt'])->name('invoice.receipt');
        Route::get('/invoices/{invoice}/payments/{payment}/edit', [InvoiceController::class, 'editPayment'])->name('invoice.editPayment');





        //Comany Settings
        Route::get('/company-settings', [CompanySettingController::class, 'companySettings'])->name('company.settings');
        Route::post('/company-settings/update', [CompanySettingController::class, 'update'])->name('company.settings.update');


        //time entry approval
        Route::get('index', [TimeEntryApprovalController::class, 'index'])->name('pages.time_entry_approval.index');

        // Routes For admin and ProjectManger Role
        Route::middleware(['auth', 'role:admin,project_manager'])->group(function () {
            Route::resource('tasks', TaskController::class);
            Route::post('projects/{project}/assign', [ProjectController::class, 'assignEmployee'])->name('projects.assign');
            Route::resource('projects', ProjectController::class);
        });
    });
});

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('/api')->name('api.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::middleware('role:project_manager,admin')->group(function () {
            Route::apiResource('users', APIUserController::class)->names([]);
            Route::apiResource('projects.users', APIProjectUserController::class)->names([]);
        });
    });
});

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::prefix('tasks/{task}/users')->group(function () {
            // Web route for the initial view
            Route::get('/', [TaskUserController::class, 'index'])->name('tasks.users.index');

            // API-style routes for AJAX calls
            Route::get('/list', [TaskUserController::class, 'getTaskUsers'])->name('tasks.users.list');
            Route::get('/available', [TaskUserController::class, 'getAvailableUsers'])->name('tasks.users.available');
            Route::post('/', [TaskUserController::class, 'store'])->name('tasks.users.store');
            Route::put('/{user}', [TaskUserController::class, 'update'])->name('tasks.users.update');
            Route::delete('/{user}', [TaskUserController::class, 'destroy'])->name('tasks.users.destroy');
        });
    });
});
