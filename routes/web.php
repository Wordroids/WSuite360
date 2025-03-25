<?php

use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\TenantController;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function () {
            return view('central.welcome');
        });

        // Authenticated routes
        Route::middleware('auth')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // Admin only routes
            Route::middleware('role:admin')->group(function () {
                Route::resource('tenants', TenantController::class);
            });
        });
    });
}

// Include Authentication Routes
require __DIR__ . '/auth.php';
