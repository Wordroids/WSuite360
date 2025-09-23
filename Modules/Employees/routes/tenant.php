<?php

use Illuminate\Support\Facades\Route;
use Modules\Employees\Http\Controllers\Tenant\EmployeeController;
use Modules\Employees\Http\Controllers\Tenant\EmployeeDocumentController;
use Modules\Employees\Http\Controllers\Tenant\DepartmentController;
use Modules\Employees\Http\Controllers\Tenant\DesignationController;

 Route::middleware(['auth', 'role:admin,hr_manager'])->group(function () {
        Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::get('/employees/get-designations', [EmployeeController::class, 'getDesignations'])
            ->name('employees.get-designations');

        Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

        // Employee Routes
        Route::get('employees/export', [EmployeeController::class, 'exportPdf'])
            ->name('employees.export');
        Route::get('employees/{employee}/deactivate', [EmployeeController::class, 'deactivateForm'])
            ->name('employees.deactivate.form');
        Route::post('employees/{employee}/deactivate', [EmployeeController::class, 'deactivate'])
            ->name('employees.deactivate');
        Route::post('employees/{employee}/reactivate', [EmployeeController::class, 'reactivate'])
            ->name('employees.reactivate');

        // Employee Document Routes
        Route::prefix('employees/{employee}/documents')->group(function () {
            Route::get('/', [EmployeeDocumentController::class, 'index'])->name('employees.documents.index');
            Route::get('/create', [EmployeeDocumentController::class, 'create'])->name('employees.documents.create');
            Route::post('/', [EmployeeDocumentController::class, 'store'])->name('employees.documents.store');
            Route::get('/{document}', [EmployeeDocumentController::class, 'show'])->name('employees.documents.show');
            Route::delete('/{document}', [EmployeeDocumentController::class, 'destroy'])->name('employees.documents.destroy');
        });
        // Department Routes
        Route::resource('departments', DepartmentController::class);
        Route::prefix('departments/{department}')->group(function () {
            Route::resource('designations', DesignationController::class)
                ->except(['show'])
                ->names([
                    'index' => 'departments.designations.index',
                    'create' => 'departments.designations.create',
                    'store' => 'departments.designations.store',
                    'edit' => 'departments.designations.edit',
                    'update' => 'departments.designations.update',
                    'destroy' => 'departments.designations.destroy',
                ]);
        });
    });
    Route::resource('employees', EmployeeController::class)->only(['index', 'show']);
