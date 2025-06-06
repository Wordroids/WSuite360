<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{

    protected $fillable = [
        'invoice_id',
        'project_id',
        'description',
        'unit_price',
        'quantity',
        'total'
    ];

    /**
     * Define relationship with Invoice model.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
