<?php

// app/Models/Attendance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attendance_date',
        'clock_in_time',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}