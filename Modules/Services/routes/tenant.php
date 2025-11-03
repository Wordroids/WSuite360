<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\Http\Controllers\Tenant\ServicesController;


Route::middleware(['auth', 'role:admin,project_manager'])->group(function () {
    Route::resource('services', ServicesController::class);

});
