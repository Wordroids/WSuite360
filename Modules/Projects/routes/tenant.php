<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoices\Http\Controllers\Tenant\InvoiceController;
use Modules\Projects\Http\Controllers\Tenant\ProjectController;
use Modules\Projects\Http\Controllers\Tenant\ProjectUserController;
use Modules\Projects\Http\Controllers\API\ProjectUserController as APIProjectUserController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware(['auth', 'role:admin,project_manager'])->group(function () {
    Route::resource('projects.users', ProjectUserController::class)->only(['index', 'store', 'destroy']);
    Route::post('projects/{project}/assign', [ProjectController::class, 'assignEmployee'])->name('projects.assign');
    Route::resource('projects', ProjectController::class);
});
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('/api')->name('api.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::middleware('role:project_manager,admin')->group(function () {
            // Route::apiResource('users', APIUserController::class)->names([]);
            Route::apiResource('projects.users', APIProjectUserController::class)->names([]);
        });
    });
});
