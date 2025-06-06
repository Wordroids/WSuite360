<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'user_id',
        'client_id',
        'invoice_number',
        'po_so_number',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total',
        'notes',
        'instructions',
        'footer',
        'status'
    ];
}
