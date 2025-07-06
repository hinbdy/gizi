<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class UpdateFoodImageUrlSeeder extends Seeder
{
    public function run(): void
    {
        $foods = Food::all();

        foreach ($foods as $food) {
            // Contoh penamaan file berdasarkan nama makanan (lowercase & underscore)
            $filename = strtolower(str_replace(' ', '_', $food->name)) . '.jpg';

            // Simulasi URL gambar — sesuaikan jika kamu pakai local file atau storage
            $food->image_url = 'https://example.com/images/' . $filename;
            $food->save();
        }
    }
}
