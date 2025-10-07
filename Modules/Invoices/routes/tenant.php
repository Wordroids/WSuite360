<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoices\Http\Controllers\Tenant\InvoiceController;
use Modules\Projects\Models\Project;
use Modules\Services\Models\Service;

Route::middleware('auth')->group(function () {
	Route::get('/invoices/{invoice}/preview-pdf', [InvoiceController::class, 'showPDF'])->name('invoice.preview');
	Route::get('/pages/invoice/index', [InvoiceController::class, 'index'])->name('invoice.index');
	Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
	Route::get('/viewInvoice', [InvoiceController::class, 'viewInvoice'])->name('invoice.show');
	Route::post('/invoice/store', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoice.update');
	Route::delete('/invoice/{invoice}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::post('/invoice/{invoice}/send', [InvoiceController::class, 'sendInvoice'])->name('invoice.send');
	Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'showPdf'])->name('invoices.showPdf');
	Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'downloadPdf'])->name('invoice.download');
	Route::post('/invoice/{invoice}/approve', [InvoiceController::class, 'approve'])->name('invoice.approve');
	Route::post('/invoice/{invoice}/mark-sent', [InvoiceController::class, 'markAsSent'])->name('invoice.markAsSent');
	Route::post('/invoices/{invoice}/record-payment', [InvoiceController::class, 'recordPayment'])->name('invoice.recordxPayment');
	Route::get('/invoices/{invoice}/payments/{payment}/receipt', [InvoiceController::class, 'receipt'])->name('invoice.receipt');
	Route::get('/invoices/{invoice}/payments/{payment}/edit', [InvoiceController::class, 'editPayment'])->name('invoice.editPayment');
    Route::post('/invoices/{invoice}/send-receipt/{payment}', [InvoiceController::class, 'sendReceipt'])->name('invoice.sendReceipt');
    Route::get('/api/clients/{client}/projects-services', function ($clientId) {
    $projects = Project::where('client_id', $clientId)->get(['id', 'name']);
    $services = Service::where('client_id', $clientId)->get(['id', 'name']);

    return response()->json([
        'projects' => $projects,
        'services' => $services
    ]);
});
Route::post('/invoices/preview-create', [InvoiceController::class, 'previewCreate'])->name('invoice.preview.create');
});
