<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMembers extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectMembersFactory> */
    use HasFactory;

    protected $fillable = ['project_id', 'user_id','created_at', 'name',          
        'role',
        'group',
        'email', 'updated_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
