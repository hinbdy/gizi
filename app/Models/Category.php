<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI
    protected $fillable = ['name', 'slug'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}