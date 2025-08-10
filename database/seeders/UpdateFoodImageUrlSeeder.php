<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;
use Illuminate\Support\Str;

class UpdateFoodImageUrlSeeder extends Seeder
{
    public function run(): void
    {
        $foods = Food::all();

        foreach ($foods as $food) {
            // Membuat nama file dari nama makanan
            $filename = Str::slug($food->name, '_') . '.png'; // Sesuaikan ekstensi jika perlu

            // ✅ PERBAIKAN: Simpan path relatif terhadap folder 'storage/app/public'
            $food->image_url = 'foods/' . $filename;
            $food->save();
        }
    }
}