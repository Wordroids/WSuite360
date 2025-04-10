<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        return view('pages.invoice.create');
    }
}
