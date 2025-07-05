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

        
    public function calculateNutrition(Request $request)
{
    // pastikan BMI sudah dihitung
    if (!session()->has('bmr')) {
        return redirect('/kalkulator-massa-tubuh')->with('warning', 'Silakan hitung BMI terlebih dahulu.');
    }

    // ambil data dari session BMI
    $usia = session('usia');
    $berat = session('berat');
    $tinggi = session('tinggi');
    $jenisKelamin = session('jenisKelamin');
    $aktivitas = session('aktivitas');
    $kategoriIMT = session('kategoriIMT');
    $kategoriBMI = session('kategoriBB');

    // Ambil data makanan dari form
    $selectedFoods = $request->input('foods', []);

    // Inisialisasi total kalori makanan
    $totalKaloriMakanan = 0;

    foreach ($selectedFoods as $foodId => $jumlahGram) {
        if ($jumlahGram > 0) {
            $food = Food::find($foodId);
            if ($food) {
                // Hitung kalori berdasarkan jumlah gram
                $kaloriPerGram = $food->kalori / 100;
                $kaloriMakanan = $jumlahGram * $kaloriPerGram;
                $totalKaloriMakanan += $kaloriMakanan;
            }
        }
    }

    // Jika user tidak input makanan, maka fallback pakai BMR session
    $kalori = $totalKaloriMakanan > 0 ? round($totalKaloriMakanan) : session('bmr');

    // Hitung makronutrien dari total kalori
    $karbohidratGram = round(($kalori * 0.50) / 4);
    $proteinGram = round(($kalori * 0.20) / 4);
    $lemakGram = round(($kalori * 0.30) / 9);

    // Deskripsi aktivitas
    $kategoriAktivitas = match ($aktivitas) {
        'sangat-ringan' => 'Minim aktivitas (misalnya duduk sepanjang hari)',
        'ringan' => 'Aktivitas ringan (misalnya guru, kasir, jalan ringan)',
        'sedang' => 'Aktivitas sedang (misalnya pekerja lapangan ringan, berdiri lama)',
        'berat' => 'Aktivitas berat (misalnya pekerja konstruksi, atlet)',
        default => 'Tidak diketahui',
    };

    // Ambil data foods (untuk tetap ditampilkan di view)
    // $foods = Food::orderBy('name', 'asc')->get();
        $foods = Food::select('id', 'name', 'kalori', 'image_url')
                 ->orderBy('name')
                 ->get()
                 ->unique('name')
                 ->values();

    // Kirim semua ke view
    return view('calculator.nutrition', [
        'title' => 'Kebutuhan Gizi Harian Anda',
        'kalori' => $kalori,
        'karbohidratGram' => $karbohidratGram,
        'proteinGram' => $proteinGram,
        'lemakGram' => $lemakGram,
        'kategoriAktivitas' => $kategoriAktivitas,
        'kategoriIMT' => $kategoriIMT,
        'berat' => $berat,
        'tinggi' => $tinggi,
        'usia' => $usia,
        'jenisKelamin' => $jenisKelamin,
        'aktivitas' => $aktivitas,
        'foods' => $foods
    ]);
}
}