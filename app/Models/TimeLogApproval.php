<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLogApproval extends Model
{
    use HasFactory;

    protected $fillable = ['time_log_id', 'break_log_id', 'manager_id', 'status', 'reason'];

    // Approval belongs to a time log
    public function timeLog()
    {
        return $this->belongsTo(TimeLog::class);
    }

    // Approval belongs to a break log
    public function breakLog()
    {
        return $this->belongsTo(BreakLog::class);
    }

    // Approval was made by a manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
