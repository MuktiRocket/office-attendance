<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';

    protected $fillable = ['branch_name','address','company_id'];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function employee()
    {
        return $this->hasMany(User::class,'branch_id','id');
    }
}
