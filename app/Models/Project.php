<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
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

    /**
     * Relationship with Client model.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function users()
{
    return $this->belongsToMany(User::class, 'project_users')->withPivot('role')->withTimestamps();
}
public function members()
{
    return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id');
}

}
