<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Food; 

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('foods')->insert([
            ['name' => 'Ayam goreng kalasan, paha', 'calories' => 250],
            ['name' => 'Ayam goreng kentucky, paha', 'calories' => 300],
            ['name' => 'Ayam goreng mentega', 'calories' => 280],
            ['name' => 'Ayam goreng tepung', 'calories' => 310],
            ['name' => 'Ayam kecap', 'calories' => 270],
            ['name' => 'Ayam rica rica', 'calories' => 265],
            ['name' => 'Ayam saus jamur', 'calories' => 240],
            ['name' => 'Ayam taliwang, masakan', 'calories' => 290],
            ['name' => 'Ayam woku', 'calories' => 275],
            ['name' => 'Bakwan', 'calories' => 200],
            ['name' => 'Bakwan jagung', 'calories' => 210],
            ['name' => 'Bantal', 'calories' => 180],
            ['name' => 'Beef burger', 'calories' => 350],
            ['name' => 'Beef teriyaki', 'calories' => 320],
            ['name' => 'Beras merah, nasi', 'calories' => 215],
            ['name' => 'Bihun goreng instan', 'calories' => 390],
            ['name' => 'Bihun kari ayam', 'calories' => 360],
        ]);
    }
}
