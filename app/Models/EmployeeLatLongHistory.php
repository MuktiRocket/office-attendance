<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLatLongHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employee_lat_long_history';

    protected $fillable = ['attendance_id', 'latitude', 'longitude'];

    protected $dateFormat = 'Y-m-d H:i:s';
}
