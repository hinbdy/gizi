<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    // Explicitly set the correct table name
    protected $table = 'foods';

    protected $fillable = ['name', 'calories'];
}
