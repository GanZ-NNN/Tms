<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
        use HasFactory; 
    protected $fillable = ['image', 'category_id', 'title', 'detail'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sessions()
    {
        return $this->hasMany(TrainingSession::class);
    }
}

