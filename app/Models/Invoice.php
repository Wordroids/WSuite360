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
        'status',
        'conversion_rate',
        'currency',
        
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
