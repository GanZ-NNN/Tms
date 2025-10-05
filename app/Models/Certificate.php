<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'cert_no',
        'pdf_path',
        'issued_at',
        'verification_hash',
    ];

    protected static function booted()
    {
        static::creating(function ($certificate) {
            $certificate->cert_no = 'CERT-' . strtoupper(Str::random(8));
            $certificate->verification_hash = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(TrainingSession::class);
    }
}
