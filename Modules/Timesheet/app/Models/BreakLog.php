<?php

namespace Modules\Timesheet\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Timesheet\Models\TimeLogApproval;

class BreakLog extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'date', 'break_time', 'status'];

    // Break log belongs to a specific employee
    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    // Break log has an approval record
    public function approval()
    {
        return $this->hasOne(TimeLogApproval::class, 'break_log_id');
    }

    // Check if break log is locked (approved)
    public function isLocked()
    {
        return $this->status === 'approved';
    }
}
