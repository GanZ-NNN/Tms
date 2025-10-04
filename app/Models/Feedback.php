<?php

namespace App\Models;

use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    protected $fillable = ['session_id', 'user_id', 'rating', 'comment'];

     public function user() {
        return $this->belongsTo(User::class);
    }

    public function session() {
        return $this->belongsTo(Session::class);
    }
}
