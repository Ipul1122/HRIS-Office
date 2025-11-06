<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','employee_code','join_date','base_salary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
