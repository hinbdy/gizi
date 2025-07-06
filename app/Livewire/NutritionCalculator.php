<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Food;

class NutritionCalculator extends Component
{
    // Properti untuk menampung data
    public $bmr;
    public $allFoods;
    public $meals = [];

    // Properti untuk hasil perhitungan real-time
    public $totalCalories = 0;
    public $totalProtein = 0;
    public $totalFat = 0;
    public $totalCarbs = 0;

    // Method ini berjalan saat komponen pertama kali dimuat
    public function mount()
    {
        $this->bmr = session('bmr', 0);

        if ($this->bmr == 0) {
            // Jika BMR belum ada di sesi, redirect ke kalkulator BMI
            return redirect()->to('/kalkulator-massa-tubuh');
        }

        // Ambil semua data makanan sekali saja untuk efisiensi
        $this->allFoods = Food::orderBy('name')->get();

        // Siapkan struktur awal untuk setiap sesi makan
        $this->meals = [
            'Sarapan' => [['food_id' => '', 'grams' => '']],
            'Makan Siang' => [['food_id' => '', 'grams' => '']],
            'Makan Malam' => [['food_id' => '', 'grams' => '']],
        ];
    }

    // Aksi untuk menambah baris menu baru
    public function addMenu($mealName)
    {
        $this->meals[$mealName][] = ['food_id' => '', 'grams' => ''];
        $this->calculateTotals(); // Hitung ulang saat baris ditambahkan
    }

    // Aksi untuk menghapus baris menu
    public function removeMenu($mealName, $index)
    {
        // Hanya hapus jika ada lebih dari 1 item
        if (count($this->meals[$mealName]) > 1) {
            unset($this->meals[$mealName][$index]);
            $this->meals[$mealName] = array_values($this->meals[$mealName]); // Re-index array
            $this->calculateTotals(); // Hitung ulang total
        }
    }

    // Hook yang berjalan setiap kali ada perubahan pada input `meals`
    public function updatedMeals()
    {
        $this->calculateTotals();
    }

    // Fungsi untuk menghitung total gizi
    public function calculateTotals()
    {
        // Reset total sebelum menghitung ulang
        $this->totalCalories = 0;
        $this->totalProtein = 0;
        $this->totalFat = 0;
        $this->totalCarbs = 0;

        foreach ($this->meals as $meal) {
            foreach ($meal as $item) {
                // Pastikan food_id dan grams tidak kosong dan merupakan angka
                if (!empty($item['food_id']) && !empty($item['grams']) && is_numeric($item['grams'])) {
                    $food = $this->allFoods->find($item['food_id']);
                    if ($food) {
                        $calories = ($food->kalori / 100) * $item['grams'];
                        $this->totalCalories += $calories;
                        // Perhitungan makro berdasarkan persentase standar Kemenkes
                        $this->totalProtein += ($calories * 0.15 / 4);
                        $this->totalFat += ($calories * 0.25 / 9);
                        $this->totalCarbs += ($calories * 0.60 / 4);
                    }
                }
            }
        }
    }

    public function render()
    {
        // Beritahu Livewire untuk menggunakan layout utama Anda
        return view('livewire.nutrition-calculator')
            ->layout('components.layout', ['title' => 'Kalkulator Gizi Harian']);
    }
}