<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_code',
        'phone_number',
        'address',
        'ktp_number',
        'gender',
        'birth_date',
        'join_date',
        'base_salary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}