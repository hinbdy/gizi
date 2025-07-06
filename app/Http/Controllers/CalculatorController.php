<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Food; 
use Illuminate\Support\Facades\DB;
class CalculatorController extends Controller
    {
        public function calculateBMI(Request $request)
        {
            $request->validate([
                'berat' => 'required|numeric|min:1|max:300',
                'tinggi' => 'required|numeric|min:1|max:300',
                'usia' => 'required|numeric|min:1|max:150',
                'jenis_kelamin' => 'required|in:male,female',
                'aktivitas' => 'required|in:sangat-ringan,ringan,sedang,berat',
            ]);

            $berat = $request->input('berat');
            $tinggi = $request->input('tinggi');
            $usia = $request->input('usia');
            $jenisKelamin = $request->input('jenis_kelamin');
            $aktivitas = $request->input('aktivitas');

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

        
 // #### FUNGSI BARU UNTUK MEMBUAT REKOMENDASI MENU ####
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
            
            // Ambil 3 menu acak yang kalorinya masuk dalam rentang
            $foods = Food::whereBetween('calories', [$minCalories, $maxCalories])
                         ->inRandomOrder()
                         ->take(3)
                         ->get();

            // Jika tidak ada makanan dalam rentang, ambil yang terdekat
            if ($foods->isEmpty()) {
                $foods = Food::select('*', DB::raw('ABS(calories - ' . $plan['target'] . ') as diff'))
                             ->orderBy('diff')
                             ->take(3)
                             ->get();
            }
            
            $recommendations[$mealName] = $foods;
        }

        return $recommendations;
    }


    public function calculateNutrition(Request $request)
    {
        // Pastikan BMR ada di session
        if (!session()->has('bmr')) {
            return redirect('/kalkulator-massa-tubuh')->with('warning', 'Silakan hitung BMI Anda terlebih dahulu.');
        }

        $bmr = session('bmr');

        // Hitung total nutrisi dari input pengguna
        $totalIntake = [
            'calories' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbs' => 0
        ];

        if ($request->has('foods')) {
            foreach ($request->input('foods') as $sesi => $menus) {
                foreach ($menus as $index => $foodId) {
                    if (!empty($foodId) && !empty($request->input("weights.$sesi.$index"))) {
                        $weight = (float)$request->input("weights.$sesi.$index");
                        $food = Food::find($foodId);
                        if ($food && $weight > 0) {
                            $factor = $weight / 100; // Kalori di DB adalah per 100g
                            $totalIntake['calories'] += $food->calories * $factor;
                            // Asumsi makronutrien (bisa diperbaiki jika ada data di DB)
                            $totalIntake['carbs'] += ($food->calories * 0.60 / 4) * $factor;
                            $totalIntake['protein'] += ($food->calories * 0.15 / 4) * $factor;
                            $totalIntake['fat'] += ($food->calories * 0.25 / 9) * $factor;
                        }
                    }
                }
            }
        }
        
        // Hitung kebutuhan harian berdasarkan BMR
        $recommendations = [
            'calories' => $bmr,
            'protein' => round(($bmr * 0.15) / 4), // 15% dari total kalori
            'fat' => round(($bmr * 0.25) / 9),     // 25% dari total kalori
            'carbs' => round(($bmr * 0.60) / 4),   // 60% dari total kalori
        ];
        
        // Buat rekomendasi menu
        $menuRecommendations = $this->_generateMenuRecommendations($bmr);

        // Data untuk FAQ
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

        return view('calculator.nutrition', [
            'title' => 'Hasil Analisis & Rekomendasi Gizi',
            'bmr' => $bmr,
            'intake' => $totalIntake,
            'recommendations' => $recommendations,
            'menuRecommendations' => $menuRecommendations,
            'faq' => $faq,
            'foods' => Food::orderBy('name')->get()
        ]);
    }

}