<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class EmployeeProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'employees';
    protected $fillable = [
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'department_id',
        'designation_id',
        'date_of_joining',
        'status',
        'inactive_reason',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'date_of_joining' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class,'employee_id');
    }

    public function statusHistory()
    {
        return $this->hasMany(EmployeeStatusHistory::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
}
