<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Food; 
use Illuminate\Support\Facades\DB;
class CalculatorController extends Controller
    {
        public function calculateBMI(Request $request)
        {
             $validatedData = $request->validate([
            'berat'         => 'required|numeric|min:20|max:300',      // Berat: minimal 20kg
            'tinggi'        => 'required|numeric|min:100|max:250',     // Tinggi: minimal 100cm
            'usia'          => 'required|numeric|min:5|max:120',       // Usia: minimal 5 tahun
            'jenis_kelamin' => 'required|in:male,female',
            'aktivitas'     => 'required|in:sangat-ringan,ringan,sedang,berat',
        ]);
            $berat = $validatedData['berat'];
            $tinggi = $validatedData['tinggi'];
            $usia = $validatedData['usia'];
            $jenisKelamin = $validatedData['jenis_kelamin'];
            $aktivitas = $validatedData['aktivitas'];

            // Hitung BMI
            $tinggiMeter = $tinggi / 100;
            $bmi = round($berat / ($tinggiMeter * $tinggiMeter), 2);
            $kategoriIMT = $this->getBMICategory($bmi);
            $kategoriBB = strtolower($kategoriIMT);
            $kategoriBeratIdeal = strtolower($kategoriIMT);

             // Link gambar kategori BB (Berat Badan)
            $bbImages = [
                'kurus' => asset('assets/images/kategori/kurus.png'),
                'normal' => asset('assets/images/kategori/normal.png'),
                'gemuk' => asset('assets/images/kategori/gemuk.png'),
                'obesitas' => asset('assets/images/kategori/obesitas.png'),
            ];
            $bbImage = $bbImages[strtolower($kategoriBB)] ?? asset('assets/images/kategori/default.png');

            // Hitung BMR (Harris-Benedict)
            if ($jenisKelamin === 'male') {
                $bmr = 66 + (13.7 * $berat) + (5 * $tinggi) - (6.8 * $usia);
            } else {
                $bmr = 655 + (9.6 * $berat) + (1.8 * $tinggi) - (4.7 * $usia);
            }

            // Faktor aktivitas dari jurnal
            $faktorAktivitas = [
            'male' => 
            [
                'sangat-ringan' => 1.30,
                'ringan' => 1.65,
                'sedang' => 1.76,
                'berat' => 2.10,
            ],
            'female' => 
            [
                'sangat-ringan' => 1.30,
                'ringan' => 1.55,
                'sedang' => 1.70,
                'berat' => 2.00,
            ],
        ];

        $kaloriHarian = round($bmr * $faktorAktivitas[$jenisKelamin][$aktivitas]);

            // Link gambar kategori IMT
        $imtImages = [
            'kurus' => asset('assets/images/kategori/meteran-kurus.png'),
            'normal' => asset('assets/images/kategori/meteran-normal.png'),
            'gemuk' => asset('assets/images/kategori/meteran-gemuk.png'),
            'obesitas' => asset('assets/images/kategori/meteran-obesitas.png'),
        ];
        $imtImage = $imtImages[strtolower($kategoriIMT)] ?? asset('assets/images/kategori/default.png');

            // Berat ideal
            $bmiIdeal = 22.5;
            $beratIdeal = round($bmiIdeal * $tinggiMeter * $tinggiMeter, 1);
            $selisihBerat = round($berat - $beratIdeal, 1);

             // Link gambar kategori berat ideal
            $idealImages = [
                'kurus' => asset('assets/images/kategori/timbang.png'),
                'normal' => asset('assets/images/kategori/timbang.png'),
                'gemuk' => asset('assets/images/kategori/timbang.png'),
                'obesitas' => asset('assets/images/kategori/timbang.png'),
            ];
            $idealImage = $idealImages[strtolower($kategoriBeratIdeal)] ?? asset('assets/images/kategori/default.png');
                // Simpan ke session
        session([
            'bmi' => $bmi,
            'kategoriIMT' => $kategoriIMT,
            'kategoriBB' => $kategoriBB,
            'kategoriBeratIdeal' => $kategoriBeratIdeal,
            'bbImage' => $bbImage,
            'imtImage' => $imtImage,
            'idealImage' => $idealImage,
            'bmr' => $kaloriHarian,
            'berat' => $berat,
            'tinggi' => $tinggi,
            'usia' => $usia,
            'jenisKelamin' => $jenisKelamin,
            'aktivitas' => $aktivitas,
            'beratIdeal' => $beratIdeal,
            'selisihBerat' => $selisihBerat,
        ]);
        
        // return redirect()->route('bmi.calculator');

            return view('calculator.bmi', [
                'title' => 'Kalkulator Massa Tubuh',
                'bmi' => $bmi,
                'kategoriIMT' => $kategoriIMT,
                'kategoriBB' => $kategoriBB,
                'kategoriBeratIdeal' => $kategoriBeratIdeal,
                'bbImage' => $bbImage,
                'imtImage' => $imtImage,
                'idealImage' => $idealImage,
                'bmr' => $kaloriHarian,
                'berat' => $berat,
                'tinggi' => $tinggi,
                'usia' => $usia,
                'jenisKelamin' => $jenisKelamin,
                'aktivitas' => $aktivitas,
                'beratIdeal' => $beratIdeal,
                'selisihBerat' => $selisihBerat,
            ]);
    }
        private function getBMICategory($bmi)
        {
            if ($bmi < 18.5) {
                return 'kurus';
            } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                return 'Normal';
            } elseif ($bmi >= 25 && $bmi < 29.9) {
                return 'Gemuk';
            } else {
                return 'Obesitas';
            }
        }

        



    public function calculateNutrition(Request $request)
    {
        // pastikan BMI sudah dihitung
        if (!session()->has('bmr')) {
            return redirect('/kalkulator-massa-tubuh')->with('warning', 'Silakan hitung BMI terlebih dahulu.');
        }

        // Aturan validasi yang ketat
        $request->validate([
            'meals' => 'required|array',
            'meals.*.*.food_id' => 'required|exists:foods,id',
            'meals.*.*.weight' => 'required|numeric|min:1',
            'meals.*.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            // Pesan error kustom dalam Bahasa Indonesia
            'meals.*.*.food_id.required' => 'Menu makanan wajib dipilih.',
            'meals.*.*.weight.required' => 'Porsi (gram) wajib diisi.',
            'meals.*.*.weight.numeric' => 'Porsi (gram) harus berupa angka.',
            'meals.*.*.weight.min' => 'Porsi (gram) minimal adalah 1.',
        ]);

        $bmr = session('bmr');

        $totalIntake = ['calories' => 0, 'protein' => 0, 'fat' => 0, 'carbs' => 0];

        foreach ($request->input('meals') as $sesi => $menus) {
            foreach ($menus as $menu) {
                if (!empty($menu['food_id']) && !empty($menu['weight'])) {
                    $food = Food::find($menu['food_id']);
                    $weight = (float)$menu['weight'];
                    if ($food && $weight > 0) {
                        $factor = $weight / 100.0;
                        // ... di dalam foreach loop
                        $totalIntake['calories'] += $food->calories * $factor;
                        $totalIntake['carbs']    += $food->carbs * $factor;    // ✅ Mengambil data akurat dari database
                        $totalIntake['protein']  += $food->protein * $factor;  // ✅ Mengambil data akurat dari database
                        $totalIntake['fat']      += $food->fat * $factor;      // ✅ Mengambil data akurat dari database
                    }
                }
            }
        }
        
        $recommendations = [
            'calories' => $bmr,
            'protein' => round(($bmr * 0.15) / 4),
            'fat' => round(($bmr * 0.25) / 9),
            'carbs' => round(($bmr * 0.60) / 4),
        ];
        
        $menuRecommendations = $this->_generateMenuRecommendations($bmr);

        $faq = [
             [
                'question' => 'Berapa kalori yang dibutuhkan tubuh?',
                'answer' => 'Kebutuhan kalori setiap orang berbeda, tergantung pada usia, jenis kelamin, berat badan, tinggi badan, dan tingkat aktivitas fisik. Rata-rata, pria dewasa membutuhkan sekitar 2.500 kkal per hari, sementara wanita dewasa membutuhkan sekitar 2.000 kkal. Kalkulator ini menggunakan rumus Harris-Benedict yang disesuaikan dengan tingkat aktivitas Anda untuk memberikan estimasi yang lebih personal.'
            ],
            [
                'question' => 'Apa itu prinsip gizi seimbang?',
                'answer' => 'Prinsip gizi seimbang adalah mengonsumsi beragam jenis makanan dalam proporsi yang tepat untuk memenuhi kebutuhan nutrisi tubuh. Ini mencakup karbohidrat sebagai sumber energi utama, protein untuk membangun dan memperbaiki jaringan tubuh, lemak untuk fungsi hormon dan penyerapan vitamin, serta vitamin dan mineral untuk menjaga fungsi tubuh tetap optimal. Penting juga untuk memastikan asupan cairan yang cukup, terutama air putih.'
            ],
            [
                'question' => 'Kelompok makanan apa saja yang penting?',
                'answer' => 'Untuk mencapai gizi seimbang, konsumsilah makanan dari berbagai kelompok berikut: <ul><li class="ml-4 list-disc"><b>Sayuran:</b> Kaya serat, vitamin, dan mineral.</li><li class="ml-4 list-disc"><b>Buah-buahan:</b> Sumber vitamin, antioksidan, dan serat alami.</li><li class="ml-4 list-disc"><b>Sumber Protein:</b> Ikan, telur, daging tanpa lemak, dan produk susu rendah lemak untuk pertumbuhan dan perbaikan sel.</li><li class="ml-4 list-disc"><b>Kacang-kacangan & Biji-bijian:</b> Sumber protein nabati, lemak sehat, dan serat.</li><li class="ml-4 list-disc"><b>Karbohidrat Kompleks:</b> Seperti nasi merah, roti gandum, dan umbi-umbian sebagai sumber energi yang tahan lama.</li></ul>'
            ]
        ];

        $data = [
            'title' => 'Hasil Analisis Gizi Anda',
            'intake' => $totalIntake,
            'recommendations' => $recommendations,
            'menuRecommendations' => $menuRecommendations,
            'faq' => $faq,
        ];

        $data['bmiData'] = session()->only([
        'bmi', 'kategoriIMT', 'kategoriBB', 'bbImage', 'imtImage',
        'idealImage', 'bmr', 'berat', 'tinggi', 'beratIdeal', 'selisihBerat'
    ]);

        $data['foods'] = Food::select(
                        DB::raw('MIN(id) as id'),
                        'name',
                        DB::raw('MIN(calories) as calories'),
                        'image_url'
                    )
                    ->groupBy('name', 'image_url')
                    ->orderBy('name', 'asc')
                    ->get();

        
        return view('calculator.nutrition', $data)->with('scroll', true);
    }

    private function _generateMenuRecommendations($bmr)
    {
        $mealPlan = [
            'Sarapan' => ['percentage' => 0.25, 'target' => $bmr * 0.25, 'variability' => 50],
            'Makan Siang' => ['percentage' => 0.35, 'target' => $bmr * 0.35, 'variability' => 75],
            'Makan Malam' => ['percentage' => 0.30, 'target' => $bmr * 0.30, 'variability' => 75],
            'Camilan' => ['percentage' => 0.10, 'target' => $bmr * 0.10, 'variability' => 50],
        ];
        $recommendations = [];
        foreach ($mealPlan as $mealName => $plan) {
            $minCalories = $plan['target'] - $plan['variability'];
            $maxCalories = $plan['target'] + $plan['variability'];
            $foods = Food::whereBetween('calories', [$minCalories, $maxCalories])->inRandomOrder()->take(3)->get();
            if ($foods->isEmpty()) {
                $foods = Food::select('*', DB::raw('ABS(calories - ' . $plan['target'] . ') as diff'))
                               ->orderBy('diff')->take(3)->get();
            }
            $recommendations[$mealName] = $foods;
        }
        return $recommendations;
    }

     public function showNutritionCalculator()
    {
        // 1. Ambil data makanan dari database (logika dari route lama Anda)
       $foods = Food::select(
    DB::raw('MIN(id) as id'),
    'name',
    'image_url',
    DB::raw('MIN(calories) as calories')
)
->groupBy('name', 'image_url')
->orderBy('name', 'asc')
->get();

        
        // 2. Kirim data ke view
        return view('calculator.nutrition', [
            'title' => 'Kalkulator Gizi Harian',
            'foods' => $foods
        ]);
    }
}