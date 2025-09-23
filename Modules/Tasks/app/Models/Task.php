<?php

namespace Modules\Tasks\Models;



use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Projects\Models\Project;
use Modules\Timesheet\Models\TimeLog;
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'assigned_to', 'title', 'description', 'status', 'start_date', 'end_date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    // Task has multiple time logs
    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'task_users')
            ->withPivot('role')
            ->withTimestamps();
    }
}
