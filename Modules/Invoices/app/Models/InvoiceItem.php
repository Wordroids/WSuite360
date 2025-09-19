<?php

namespace Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Projects\Models\Project;
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

    /**
     * Define relationship with Project model.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
