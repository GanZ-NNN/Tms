<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'session_id',
        'user_id',
        'sex',
        'age',
        'speakers',
        'content',
        'staff',
        'overall',
        'pre_knowledge',
        'post_knowledge',
        'comment',
        'future_topics',
        'submitted_at',
    ];

    protected $casts = [
        'speakers' => 'array',
        'content' => 'array',
        'staff' => 'array',
        'future_topics' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function trainingSession()
    {
        return $this->belongsTo(TrainingSession::class, 'session_id');
    }
}
