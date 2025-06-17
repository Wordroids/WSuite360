<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'address',
        'logo', 'vat_number', 'currency', 'footer_note',
    ];
}
