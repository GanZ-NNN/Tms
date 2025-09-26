<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'trainer_id',
        'session_number',
        'location',
        'start_at',
        'end_at',
        'registration_start_at',
        'registration_end_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
        protected $casts = [
        'start_at'              => 'datetime', // <-- บอกให้แปลงเป็น Object วันที่
        'end_at'                => 'datetime', // <-- บอกให้แปลงเป็น Object วันที่
        'registration_start_at' => 'datetime',
        'registration_end_at'   => 'datetime',
    ];

    // ความสัมพันธ์กับ Program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // ความสัมพันธ์กับ Trainer
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
        public function registrations()
    {
        // Session หนึ่งอัน มีได้หลาย Registration
        return $this->hasMany(Registration::class, 'session_id'); 
    }
        public function attendances()
    {
        // Session หนึ่งอัน มีได้หลาย Attendance record
        return $this->hasMany(Attendance::class, 'session_id'); 
    }

}
