<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // Relasi ke artikel
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
