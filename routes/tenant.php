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
use App\Http\Controllers\LeaveTypeController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;

use App\Http\Controllers\AdminUserController;

use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectCardPaymentController;
use App\Http\Controllers\ProjectPaymentController;

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



        //Payment Routes
        Route::prefix('project-payment')->group(function () {
            Route::get('/', [ProjectPaymentController::class, 'index'])->name('project-payment.index');
            Route::get('/projects/{clientId}', [ProjectPaymentController::class, 'getProjects'])->name('project-payment.projects');
            Route::post('/setup-becs', [ProjectPaymentController::class, 'setupBecs'])->name('project-payment.setupBecs');
            Route::post('/process', [ProjectPaymentController::class, 'processPayment'])->name('project-payment.process');
        });

        // Main payment routes
        Route::prefix('payments')->group(function () {
            // Index page
            Route::get('/', [PaymentController::class, 'index'])->name('payments.index');

            // Bank payment routes
            Route::get('/bank-charge', [ProjectPaymentController::class, 'selectBank'])->name('payments.bank-charge');
            Route::get('/projects/{clientId}', [ProjectPaymentController::class, 'getProjects'])->name('payments.projects');
            Route::get('/bank-process', [ProjectPaymentController::class, 'process'])->name('payments.bank-process');
            Route::post('/bank-confirm', [ProjectPaymentController::class, 'confirm'])->name('payments.bank-confirm');
            Route::get('/select-bank/{clientId}', [ProjectPaymentController::class, 'selectBank'])->name('payments.selectBank');
            Route::post('/cancel-subscription', [PaymentController::class, 'cancelSubscription'])->name('payments.cancelSubscription');
            // Card payment routes
            Route::get('/select-card/{clientId}', [ProjectCardPaymentController::class, 'selectCard'])->name('payments.selectCard');
            Route::get('/card-charge', [ProjectCardPaymentController::class, 'selectCard'])->name('payments.card-charge');
            Route::get('/projects/{clientId}', [ProjectCardPaymentController::class, 'getProjects'])->name('payments.projects');
            Route::post('/card-confirm', [ProjectCardPaymentController::class, 'confirm'])->name('payments.card-confirm');
            Route::post('/card-process', [ProjectCardPaymentController::class, 'process'])->name('payments.card-process');
        });



        //Activity log
        Route::get('/logs', [ActivityLogController::class, 'logs'])->name('pages.activity_log.logs');


        Route::get('employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');


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
        // Project Manager Routes (Approvals & Manager Dashboard)
        Route::middleware('role:project_manager,admin')->group(function () {



            // Project member assingment

        });


        //user routes
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('users', AdminUserController::class)->except(['create', 'store']);
        });
        Route::get('users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');

        Route::get('/pages/users/index', [AdminUserController::class, 'index'])->name('pages.users.index');


        //Comany Settings
        Route::get('/company-settings', [CompanySettingController::class, 'companySettings'])->name('company.settings');
        Route::post('/company-settings/update', [CompanySettingController::class, 'update'])->name('company.settings.update');
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
            //  Route::apiResource('projects.users', APIProjectUserController::class)->names([]);
        });
    });
});

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {});
