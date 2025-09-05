<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDocument extends Model
{
     use HasFactory;

    protected $fillable = [
        'employee_id',
        'document_type',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'description',
        'uploaded_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employeeprofile::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
