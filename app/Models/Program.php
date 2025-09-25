<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['image', 'category_id', 'title', 'detail', 'capacity'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sessions()
{
    return $this->hasMany(TrainingSession::class);
}
}

