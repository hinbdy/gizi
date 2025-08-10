<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi massal
     */
    protected $fillable = [
        'user_id',
        'article_id',
        'body',
        'guest_name',
        'guest_email',
        'parent_id', // tambahkan ini
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(function ($user, $comment) {
            $user->name = $comment->guest_name;
        });
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Relasi balasan komentar
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->orderBy('created_at', 'asc'); // urut balasan
    }
}
