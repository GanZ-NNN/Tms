<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\SessionFactory;
use Carbon\CarbonPeriod;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'trainer_id',
        'session_number',
        'location',
        'capacity',
        'status',
        'start_at',
        'end_at',
        'registration_start_at',
        'registration_end_at',
        'level',
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
        public function level()
    {
        // Session หนึ่งอัน เป็นของ Level หนึ่งอัน
        return $this->belongsTo(Level::class);
    }
        /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        // บอกให้ Model นี้ใช้ Factory ที่ชื่อ SessionFactory
        return SessionFactory::new();
    }
        public function feedback()
    {
        // Session หนึ่งอัน มีได้หลาย Feedback
        return $this->hasMany(Feedback::class, 'session_id');
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'session_id');
    }
    public const LEVEL_BEGINNER = 'Beginner';
    public const LEVEL_INTERMEDIATE = 'Intermediate';
    public const LEVEL_EXPERT = 'Expert';

    public static function getLevels(): array
    {
        return [
            self::LEVEL_BEGINNER,
            self::LEVEL_INTERMEDIATE,
            self::LEVEL_EXPERT,
        ];
    }

    // ---------------------------------------------------------
    // ✅ เพิ่มส่วนนี้เพื่อรองรับระบบใบรับรอง
    // ---------------------------------------------------------

    /**
     * คำนวณเปอร์เซ็นต์การเข้าร่วมของผู้ใช้
     */
    public function attendanceRateFor($user)
    {
        $attendedSlots = 0;

        foreach ($this->registrations as $registration) {
            if ($registration->user_id !== $user->id) continue;

            foreach ($registration->dailyAttendances as $daily) {
                $attendedSlots += ($daily->is_present_am ? 1 : 0);
                $attendedSlots += ($daily->is_present_pm ? 1 : 0);
            }
        }

        $period = CarbonPeriod::create($this->start_at, $this->end_at);
        $totalSlots = count($period) * 2;

        if ($totalSlots === 0) return 0;

        return round(($attendedSlots / $totalSlots) * 100, 2);
    }


    /**
     * ตรวจสอบว่าผู้ใช้นี้ทำแบบประเมินแล้วหรือยัง
     */
    public function hasFeedbackFrom($user)
    {
        return $this->feedback()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * ตรวจสอบว่าผ่านเงื่อนไขออกใบรับรองหรือยัง
     * (เข้าร่วม >= 80% และทำแบบประเมินแล้ว)
     */
    public function eligibleForCertificate(User $user)
{
    return $this->attendanceRateFor($user) >= 80 && $this->hasFeedbackFrom($user);
}


}
