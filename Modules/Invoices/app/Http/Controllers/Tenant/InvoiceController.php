<?php

namespace Modules\Invoices\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;

// External models
use App\Models\CompanySettings;


// Module models
use Modules\Invoices\Models\Invoice;
use Modules\Projects\Models\Project;
use Modules\Clients\Models\Client;
use Modules\Invoices\Models\InvoicePayment;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoiceMail;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('client');

        // Apply filters
        if ($request->has('client') && $request->client) {
            $query->where('client_id', $request->client);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('invoice_date', $request->date);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()->paginate(10);
        $clients = Client::all();

        return view('invoices::pages.invoice.index', compact('invoices', 'clients'));
    }

    //To view an invoice
    public function viewInvoice(Request $request)
    {

        $invoice = Invoice::with(['client', 'items.project'])->findOrFail($request->id);
        $payments = $invoice->payments()->latest()->get();
        $due = $invoice->total - $payments->sum('amount');
        $invoice->due = $due;


        $company = CompanySettings::first();
        return view('invoices::pages.invoice.viewInvoice', compact('invoice', 'company', 'payments'));
    }
    //To create an invoice
    public function create()
    {
        $clients = Client::all();
        $projects = Project::all(['id', 'name']);
        $companySettings = CompanySettings::first();
        return view('invoices::pages.invoice.create', compact('clients', 'projects', 'companySettings'));
    }

    public function store(Request $request)
    {

        // Validate the request data
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'client_id' => 'required',
            'currency' => 'required',
            'invoice_number' => 'required',
            'po_so_number' => 'nullable',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'subtotal' => 'required',
            'total' => 'required',
            'notes' => 'nullable',
            'instructions' => 'nullable',
            'footer' => 'nullable',
        ]);

        $invoice = Invoice::create([
            'user_id' => auth()->id(), // Assuming the user is authenticated
            'title' => $request->title,
            'description' => $request->description,
            'client_id' => $request->client_id,
            'currency' => $request->currency,
            'invoice_number' => $request->invoice_number,
            'po_so_number' => $request->po_so_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            'notes' => $request->notes,
            'instructions' => $request->instructions,
            'footer' => $request->footer,
            'status' => 'draft', // Default status
        ]);

        // If there are items in the request, associate them with the invoice
        if ($request->has('products')) {
            foreach ($request->products as $product) {
                $invoice->items()->create([
                    'project_id' => $product['project_id'],
                    'description' => $product['description'],
                    'unit_price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'total' => $product['price'] * $product['quantity'],
                ]);
            }
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
    }

    // edit
    public function edit(Invoice $invoice)
    {
        $clients = Client::all();
        $projects = Project::all(['id', 'name']);
        $companySettings = CompanySettings::first();

        $products = $invoice->items->map(function ($item) {
            return [
                'id'          => $item->id,
                'project_id'  => $item->project_id,
                'description' => $item->description,
                'quantity'    => $item->quantity,
                'price'       => $item->unit_price,
                'project_name' => $item->project->name ?? '',
            ];
        });

        return view('invoices::pages.invoice.edit', compact('invoice', 'clients', 'projects', 'companySettings', 'products'));
    }
    //to update
    public function update(Request $request, Invoice $invoice)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'client_id' => 'required',
            'currency' => 'required',
            'invoice_number' => 'required',
            'po_so_number' => 'nullable',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'subtotal' => 'required',
            'total' => 'required',
            'notes' => 'nullable',
            'instructions' => 'nullable',
            'footer' => 'nullable',
        ]);

        $invoice->update([
            'title' => $request->title,
            'description' => $request->description,
            'client_id' => $request->client_id,
            'currency' => $request->currency,
            'invoice_number' => $request->invoice_number,
            'po_so_number' => $request->po_so_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            'notes' => $request->notes,
            'instructions' => $request->instructions,
            'footer' => $request->footer,
        ]);

        if ($request->has('products')) {
            $existingItemIds = [];

            foreach ($request->products as $productData) {
                if (isset($productData['id'])) {

                    $item = $invoice->items()->find($productData['id']);
                    if ($item) {
                        $item->update([
                            'project_id' => $productData['project_id'],
                            'description' => $productData['description'],
                            'unit_price' => $productData['price'],
                            'quantity' => $productData['quantity'],
                            'total' => $productData['price'] * $productData['quantity'],
                        ]);
                        $existingItemIds[] = $item->id;
                    }
                } else {

                    $item = $invoice->items()->create([
                        'project_id' => $productData['project_id'],
                        'description' => $productData['description'],
                        'unit_price' => $productData['price'],
                        'quantity' => $productData['quantity'],
                        'total' => $productData['price'] * $productData['quantity'],
                    ]);
                    $existingItemIds[] = $item->id;
                }
            }

            $invoice->items()->whereNotIn('id', $existingItemIds)->delete();
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
    }

    public function approve(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return back()->with('error', 'Invoice is already approved.');
        }

        $invoice->status = 'overdue'; // Set to overdue when approved
        $invoice->save();

        return back()->with('success', 'Invoice approved successfully.');
    }

    public function markAsSent(Invoice $invoice)
    {
        if ($invoice->status !== 'overdue') {
            return back()->with('error', 'Invoice must be approved before sending.');
        }

        $invoice->status = 'sent';
        $invoice->sent_at = now();
        $invoice->save();

        return back()->with('success', 'Invoice marked as sent.');
    }

    public function recordPayment(Request $request, Invoice $invoice)
    {


        $request->validate([
            'payment_date' => 'required',
            'amount' => 'required',
            'payment_method' => 'nullable',
            'payment_account' => 'nullable',
            'notes' => 'nullable',
        ]);

        // Save payment
        InvoicePayment::create([
            'invoice_id'      => $invoice->id,
            'payment_date'    => $request->payment_date,
            'amount'          => $request->amount,
            'payment_method'  => $request->payment_method,
            'payment_account' => $request->payment_account,
            'notes'           => $request->notes,
        ]);

        // Update invoice
        // Check if the total amount has been paid
        $totalPaid = $invoice->payments()->sum('amount');
        if ($totalPaid == $invoice->total) {
            $invoice->status = 'paid';
        } else {
            $invoice->status = 'partialy-paid';
        }
        $invoice->paid_at = $request->payment_date;
        $invoice->save();

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }


    /*public function downloadPdf(Request $request, Invoice $invoice)
    {
        $invoice->load(['client', 'items.project']);
        $payments = $invoice->payments()->latest()->get();
        $due = $invoice->total - $payments->sum('amount');
        $invoice->due = $due;

        $company = CompanySettings::first();

        $template = view('invoices::pdf.pdf', compact('invoice', 'company', 'payments'))->render();

        $html = view('invoices::pdf.pdf', compact('invoice', 'company', 'payments'))->render();

        $pdfPath = storage_path('app/public/invoice-' . $invoice->id . '.pdf');

        Browsershot::html($html)
            ->setNodeBinary('/opt/homebrew/bin/node')
            ->setNpmBinary('/opt/homebrew/bin/npm')
            ->format('A4')
            ->waitUntilNetworkIdle()
            ->setDelay(2000) // wait 2 seconds before capture
            ->timeout(220)   // give it more time
            ->dumpBrowserConsoleLog()
            ->save($pdfPath);



        // To download
        return $template;
    }*/

    public function downloadPdf(Request $request, Invoice $invoice)
    {
        $invoice->load(['client', 'items.project', 'payments']);
        $payments = $invoice->payments;
        $due = $invoice->total - $payments->sum('amount');
        $invoice->due = $due;

        $company = CompanySettings::first();

        // Convert logo to base64 if it exists
        if ($company && $company->logo) {
            $imagePath = storage_path('app/public/' . $company->logo);
            if (file_exists($imagePath)) {
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageData = file_get_contents($imagePath);
                $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
                $company->base64_logo = $base64Image;
            }
        }

        // Use the correct namespace for Spatie's Laravel-PDF
        return Pdf::view('invoices::pdf.pdf', [
            'invoice' => $invoice,
            'company' => $company,
            'payments' => $payments,
        ])
            ->format(Format::A4)
            ->name('invoice-' . $invoice->invoice_number . '.pdf')
            ->download();
    }

    public function showPDF(Request $request, Invoice $invoice)
    {
        $invoice->load(['client', 'items.project']);
        $payments = $invoice->payments()->latest()->get();
        $due = $invoice->total - $payments->sum('amount');
        $invoice->due = $due;

        $company = CompanySettings::first();

        return view('invoices::pdf.pdf', compact('invoice', 'company', 'payments'));
    }

    //to delete invoice
    public function destroy(Invoice $invoice)
    {
        try {
            // Delete related items first
            $invoice->items()->delete();
            $invoice->payments()->delete();


            $invoice->delete();

            return redirect()->route('invoice.index')
                ->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('invoice.index')
                ->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }
    
    public function sendInvoice(Request $request, Invoice $invoice)
    {
        try {
            \Log::info('=== STARTING INVOICE SEND PROCESS ===');
            \Log::info('Invoice ID: ' . $invoice->id);
            \Log::info('Invoice Status: ' . $invoice->status);
            \Log::info('Client Email: ' . ($invoice->client->email ?? 'No email'));

            // Check if invoice can be sent
            $allowedStatuses = ['overdue', 'sent', 'partialy-paid', 'draft'];
            if (!in_array($invoice->status, $allowedStatuses)) {
                \Log::warning('Invoice cannot be sent with status: ' . $invoice->status);
                return back()->with('error', 'Invoice cannot be sent with current status.');
            }

            // Validate client email
            if (!$invoice->client || !filter_var($invoice->client->email, FILTER_VALIDATE_EMAIL)) {
                \Log::error('Invalid client email: ' . ($invoice->client->email ?? 'null'));
                return back()->with('error', 'Valid client email address is required.');
            }

            // Test email configuration
            \Log::info('Mail Configuration Check:');
            \Log::info('Default Mailer: ' . config('mail.default'));
            \Log::info('SMTP Host: ' . config('mail.mailers.smtp.host'));
            \Log::info('SMTP Port: ' . config('mail.mailers.smtp.port'));
            \Log::info('SMTP Username: ' . config('mail.mailers.smtp.username'));

            $company = CompanySettings::first();
            if (!$company) {
                \Log::error('Company settings not found');
                return back()->with('error', 'Company settings not configured.');
            }

            // Send email with detailed logging
            \Log::info('Attempting to send email to: ' . $invoice->client->email);

            Mail::to($invoice->client->email)
                ->send(new SendInvoiceMail($invoice, $company));

            // Check for failures
            if (count(Mail::failures()) > 0) {
                \Log::error('Email failed to send. Failures: ' . implode(', ', Mail::failures()));
                return back()->with('error', 'Failed to send email.');
            }

            \Log::info('Email sent successfully!');

            // Update invoice
            $invoice->status = 'sent';
            $invoice->sent_at = now();
            $invoice->save();

            \Log::info('Invoice status updated to "sent"');

            return back()->with('success', 'Invoice sent successfully to ' . $invoice->client->email);
        } catch (\Exception $e) {
            \Log::error('SEND INVOICE ERROR: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to send invoice: ' . $e->getMessage());
        }
    }
}
