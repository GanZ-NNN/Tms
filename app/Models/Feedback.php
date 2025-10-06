<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'session_id',
        'user_id',
        'sex',
        'sex_other',
        'age',
        'speakers',
        'content',
        'faculty_related',
        'staff',
        'overall',
        'pre_knowledge',
        'post_knowledge',
        'want_news',
        'news_channels',
        'news_channels_other',
        'participated_before',
        'activity_format',
        'activity_format_other',
        'instructor_info_influence',
        'outside_hours_influence',
        'future_topics_other',
        'comment',
        'future_topics',
        'submitted_at',
    ];

    protected $casts = [
        'speakers' => 'array',
        'content' => 'array',
        'staff' => 'array',
        'faculty_related' => 'array',
        'news_channels' => 'array',
        'participated_before' => 'array',
        'activity_format' => 'array',
        'activity_format_other' => 'array',
        'instructor_info_influence' => 'array',
        'outside_hours_influence' => 'array',
        'future_topics_other' => 'array',
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
