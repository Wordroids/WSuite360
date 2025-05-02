<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'assigned_to', 'title', 'description', 'status', 'start_date', 'end_date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_users')->withTimestamps();
    }

    // Task has multiple time logs
    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }
}
