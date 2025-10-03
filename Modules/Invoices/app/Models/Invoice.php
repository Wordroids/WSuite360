<?php

namespace Modules\Invoices\Models;

use Modules\Clients\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
        'sent_at',
        'paid_at',

    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'sent_at' => 'datetime',
        'paid_at' => 'datetime',
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

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    // Auto generate invoice ID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $count = \Modules\Invoices\Models\Invoice::count();
                $nextNumber = $count + 1;
                $invoice->invoice_number = 'INV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
