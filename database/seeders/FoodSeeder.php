<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Food; 

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FoodsTableSeeder::class,
            // Anda bisa menambahkan seeder lain di sini jika ada
        ]);
    }
}
