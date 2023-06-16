<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employee_attendance';
    protected $fillable = ['user_id', 'attendance_category', 'address', 'in_profile_image', 'in_latitude', 'in_longitude', 'company_id', 'created_at', 'updated_at', 'out_profile_image', 'out_longitude', 'out_latitude', 'attendance_given'];
    protected $dates = ['out_date'];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function category()
    {
        return $this->belongsTo(AttendanceCategory::class, 'attendance_category');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
