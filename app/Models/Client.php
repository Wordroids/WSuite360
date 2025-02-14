<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'email', 'phone', 'address', 'company_id'];

    /**
     * Define relationship with Company model.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
