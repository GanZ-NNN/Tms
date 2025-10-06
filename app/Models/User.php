<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_TRAINEE = 'trainee';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'occupation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

        public function registrations()
    {
        return $this->hasMany(\App\Models\Registration::class);
    }

    // app/Models/User.php
    public function certificates()
    {
        return $this->hasMany(\App\Models\Certificate::class);
    }

}
