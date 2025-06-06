<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('pages.invoice.index');
    }
    //To view an invoice
    public function viewInvoice()
    {
        return view('pages.invoice.viewInvoice');
    }
    //To create an invoice
    public function create()
    {
        $clients = Client::all();
        $projects = Project::all(['id', 'name']);
        return view('pages.invoice.create' , compact('clients', 'projects'));
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

        return redirect()->route('pages.invoice.index')->with('success', 'Invoice created successfully.');
    }
}
