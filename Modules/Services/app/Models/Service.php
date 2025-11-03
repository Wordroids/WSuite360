<?php

namespace Modules\Services\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Clients\Models\Client;
use Modules\Subscriptions\Models\ProjectSubscription;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'client_id',
        'start_date',
        'end_date',
        'status',
        'budget',
        'priority',
    ];
     public function client()
    {
        return $this->belongsTo(Client::class);
    }


      public function subscriptions()
    {
        return $this->hasMany(ProjectSubscription::class);
    }
}
