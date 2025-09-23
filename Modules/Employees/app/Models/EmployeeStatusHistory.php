<?php
namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
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
        return $this->belongsTo(EmployeeProfile::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
