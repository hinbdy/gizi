<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo', // Pastikan ini ada
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function getProfilePhotoUrlAttribute()
    {
        // DIUBAH: Hapus `file_exists()` yang lambat.
        // Logika baru: Jika kolom 'photo' berisi teks (tidak null/kosong),
        // langsung tampilkan gambarnya. Ini jauh lebih cepat.
        if ($this->photo) {
             return asset('storage/' . $this->photo);
        }

        // Jika kolom 'photo' kosong, gunakan avatar default.
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=d6f6e4&color=052e16&bold=true';
    }
}