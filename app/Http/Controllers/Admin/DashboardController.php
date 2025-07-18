<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category; 
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $articles = Article::latest()->limit(5)->get();
        $totalArticles = Article::count();
        $chartData = [];
        // --- Persiapan Data Grafik (Sama seperti sebelumnya) ---
        $months = [];
        $visitCounts = [];
        $totalArticleCounts = [];
        $publishedArticleCounts = [];
        $draftArticleCounts = [];

        for ($i = 11; $i >= 0; $i--) {
            $carbonDate = Carbon::now()->subMonths($i);
            $year = $carbonDate->year;
            $month = $carbonDate->month;
            $months[] = $carbonDate->format('M Y');
            $visitCounts[] = Article::whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('views');
            $totalArticleCounts[] = Article::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            $publishedArticleCounts[] = Article::where('published', true)->whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            $draftArticleCounts[] = Article::where('published', false)->whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
        }

        $chartData = [
            'months'                 => $months,
            'visitCounts'            => $visitCounts,
            'totalArticleCounts'     => $totalArticleCounts,
            'publishedArticleCounts' => $publishedArticleCounts,
            'draftArticleCounts'     => $draftArticleCounts,
        ];

        // --- BAGIAN BARU: ANALISIS DATA & MEMBUAT TEKS KETERANGAN ---
        $summaryTexts = [
            'visits' => $this->generateComparisonText(
                $visitCounts, 'kunjungan', 'pengunjung'
            ),
            'total' => $this->generateComparisonText(
                $totalArticleCounts, 'artikel dibuat', 'target jumlah artikel'
            ),
            'published' => $this->generateComparisonText(
                $publishedArticleCounts, 'artikel diterbitkan', 'target artikel terbit'
            ),
            'draft' => $this->generateComparisonText(
                $draftArticleCounts, 'artikel disimpan', 'perbandingan artikel'
            ),
        ];

        $categories = Category::withCount('articles')
                                ->having('articles_count', '>', 0)
                                ->orderBy('articles_count', 'desc')
                                ->get();
        
        // Mengirim semua data ke view, termasuk teks keterangan yang baru
        return view('admin.dashboard', compact('user', 'articles', 'totalArticles', 'chartData', 'summaryTexts', 'categories'));
    }

    /**
     * Fungsi bantuan untuk membuat teks perbandingan antara bulan ini dan bulan lalu.
     */
    private function generateComparisonText(array $data, string $metricName, string $goalText): string
    {
        // Ambil data bulan ini (elemen terakhir) dan bulan lalu (elemen kedua dari terakhir)
        $currentMonthData = end($data);
        $previousMonthData = prev($data);

        // Jika tidak ada data bulan lalu, beri keterangan default
        if ($previousMonthData === false) {
            return "Data bulan sebelumnya tidak tersedia untuk perbandingan.";
        }

        $difference = $currentMonthData - $previousMonthData;

        // PERUBAHAN DI SINI: Menggunakan tag <strong> untuk bold, bukan **
        if ($difference > 0) {
            return "📈 Terjadi <strong>peningkatan</strong> sebanyak <strong>$difference $metricName</strong> dari bulan lalu. Ini menunjukkan adanya pertumbuhan $goalText yang positif.";
        } elseif ($difference < 0) {
            $absDifference = abs($difference);
            return "📉 Terjadi <strong>penurunan</strong> sebanyak
            <strong>$absDifference $metricName</strong> dari bulan lalu. Perlu evaluasi untuk meningkatkan $goalText bulan depan.";
        } else {
            return "⚖️ Jumlahnya <strong>stabil</strong> dibandingkan bulan lalu. Pertahankan konsistensi untuk mencapai $goalText.";
        }
    }
}