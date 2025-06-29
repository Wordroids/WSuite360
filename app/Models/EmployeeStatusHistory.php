<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EmployeeStatusHistory extends Model
{
    use HasFactory;

     protected $table = 'employee_status_history';
    protected $fillable = [
        'employee_id',
        'previous_status',
        'new_status',
        'reason',
        'changed_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
