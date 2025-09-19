<?php

use Illuminate\Support\Facades\Route;
use Modules\Clients\Http\Controllers\Tenant\ClientController;

        Route::middleware('role:admin')->group(function () {

            Route::resource('clients', ClientController::class);
            Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
        });

