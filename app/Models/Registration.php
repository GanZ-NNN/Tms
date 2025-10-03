<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_id', 'status'];


    // =======================================================
    // ===       เพิ่ม 2 ฟังก์ชันนี้เข้าไป       ===
    // =======================================================
    
    /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        // Registration หนึ่งอัน เป็นของ User หนึ่งคน
        return $this->belongsTo(User::class);
    }

    /**
     * Get the session that the registration belongs to.
     */
    public function session()
    {
        // Registration หนึ่งอัน เป็นของ Session หนึ่งอัน
        return $this->belongsTo(TrainingSession::class, 'session_id');
    }
    // =======================================================
        public function dailyAttendances()
    {
        // Registration หนึ่งอัน มีได้หลาย DailyAttendance record (สำหรับแต่ละวัน)
        return $this->hasMany(DailyAttendance::class); 
    }
    // public function feedback()
    // {
    //     return $this->hasOne(Feedback::class);
    // }
}