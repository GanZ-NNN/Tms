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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {
            // รหัสใบรับรอง เช่น CERT-2025-0001
            $certificate->cert_no = 'CERT-' . now()->format('Y') . '-' . strtoupper(Str::random(6));

            // ใช้สำหรับตรวจสอบผ่าน QR
            $certificate->verification_hash = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(TrainingSession::class, 'session_id');
    }
}
