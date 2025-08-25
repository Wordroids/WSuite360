<?php

namespace Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $fillable = [
        'invoice_id', 'payment_date', 'amount', 'payment_method', 'payment_account', 'notes',
    ];

    protected $casts = [
        'payment_date' => 'date'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    
}
