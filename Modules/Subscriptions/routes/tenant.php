<?php

use Illuminate\Support\Facades\Route;
use Modules\Subscriptions\Http\Controllers\Tenant\ProjectPaymentController;
use Modules\Subscriptions\Http\Controllers\Tenant\PaymentController;
use Modules\Subscriptions\Http\Controllers\Tenant\ProjectCardPaymentController;

 Route::middleware('auth')->group(function () {
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

    });
