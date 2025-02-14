<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'task_id', 'project_id', 'date', 'time_spent', 'billable', 'status'];

    // Time log belongs to a specific employee
    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    // Time log is linked to a specific task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Time log is linked to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Time log has an approval status
    public function approval()
    {
        return $this->hasOne(TimeLogApproval::class);
    }

    // Check if time log is locked (approved)
    public function isLocked()
    {
        return $this->status === 'approved';
    }
}
