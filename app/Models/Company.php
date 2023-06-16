<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companies';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
