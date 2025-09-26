<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;


    protected $table = 'training_sessions';

    protected $fillable = [
        'program_id', 'trainer_id', 'level_id', //'title', 
        'start_at', 
        'end_at', 
        //'capacity', 
        'location', 'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
    ];

    public function program() {
        return $this->belongsTo(Program::class);
    }
    public function trainer() {
        return $this->belongsTo(Trainer::class);
    }
    public function registrations() {
        return $this->hasMany(Registration::class);
    }
    public function attendances() {
        return $this->hasMany(Attendance::class);
    }

}