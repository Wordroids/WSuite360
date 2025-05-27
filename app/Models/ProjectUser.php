<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectUser extends Model
{
    use HasFactory;

    protected $table = 'project_users';

    protected $fillable = [
        'user_id',
        'project_id',
        'role',
    ];

    //Relationship with User model.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relationship with Project model.
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
