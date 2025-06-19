<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProjectSubscription extends Model
{
      use HasFactory;

    protected $fillable = [
        'client_id',
        'project_id',
        'stripe_subscription_id',
        'status',
        'amount',
        'currency',
        'billing_cycle',
        'notes'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
