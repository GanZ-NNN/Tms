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
}
