<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'employee_id', 'name', 'description', 'start_date', 'end_date', 'status'];

    // Task belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Task is assigned to one employee
    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    // Task has multiple time logs
    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }
}
