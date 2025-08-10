<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

   protected $fillable = [
    'title',
    'content',
    'excerpt',
    'published',
    'category_id',
    'thumbnail',
    'slug',
    'user_id',
    'views',
];

    protected $casts = [
        'published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        
    ];

    public function getRouteKeyName()
    {
    return 'slug';
    
    }

    // Relasi ke user penulis (jika ada)
        public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
     // Relasi ke kategori artikel
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }   
    public function setTitleAttribute($value)
    {
    $this->attributes['title'] = $value;

    // Generate slug dari title
    $this->attributes['slug'] = Str::slug($value);
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}
}
