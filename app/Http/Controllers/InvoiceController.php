<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CompanySettings;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Project;
//use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('client')
            ->when($request->client, fn($q) => $q->where('client_id', $request->client))
            ->when($request->date, fn($q) => $q->whereDate('date', $request->date))
            ->latest()
            ->paginate(10);

        $clients = Client::all();

        return view('pages.invoice.index', compact('invoices', 'clients'));
    }

    //To view an invoice
    public function viewInvoice(Request $request)
    {

        $invoice = Invoice::with(['client', 'items.project'])->findOrFail($request->id);
        $payments = $invoice->payments()->latest()->get();
        $due = $invoice->total - $payments->sum('amount');
        $invoice->due = $due;


        $company = CompanySettings::first();
        return view('pages.invoice.viewInvoice', compact('invoice', 'company', 'payments'));
    }
    //To create an invoice
    public function create()
    {
        $clients = Client::all();
        $projects = Project::all(['id', 'name']);
        $companySettings = CompanySettings::first();
        return view('pages.invoice.create', compact('clients', 'projects', 'companySettings'));
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

        $template = view('pdf.pdf', compact('invoice', 'company', 'payments'))->render();
        
        $html = view('pdf.pdf', compact('invoice', 'company', 'payments'))->render();

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
    return Pdf::view('pdf.pdf', [
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

        return view('pdf.pdf', compact('invoice', 'company', 'payments'));
    }
}
