<?php

use Illuminate\Support\Facades\Route;
use Modules\Tasks\Http\Controllers\Tenant\TaskController;
use Modules\Tasks\Http\Controllers\Tenant\TaskUserController;

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

    Route::middleware(['role:admin,project_manager'])->group(function () {
        Route::resource('tasks', TaskController::class);
    });
});