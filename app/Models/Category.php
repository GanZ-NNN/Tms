<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
        use HasFactory;
    protected $fillable = ['name'];

    // ความสัมพันธ์กับ Program
    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}

