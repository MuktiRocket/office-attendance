<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendance_categories';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['category_name','company_id'];
}
