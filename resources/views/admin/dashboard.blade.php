@props(['title' => 'Dashboard Admin Artikel Gizila'])

<x-layouts.admin :title="$title">
    {{-- Bagian Header & Greeting (Tidak Diubah) --}}
    <div class="flex items-center gap-4 mb-8 border-b border-green-500 pb-6">
        @if ($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-20 h-20 rounded-full object-cover shadow-lg ring-2 ring-green-500">
        @else
            <div class="w-20 h-20 rounded-full bg-green-200 flex items-center justify-center text-2xl font-bold text-white">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
        <div>
            <h2 class="text-2xl font-semibold text-gizila-dark dark:text-white">
                <span id="greeting"></span>, {{ $user->name }}👋
            </h2>
            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">Selamat datang kembali di Dashboard admin Gizila.</p>
        </div>
    </div>
    <p class="text-sm text-gray-500 dark:text-white mb-6">Waktu sekarang: <span id="current-time"></span></p>

    {{-- KONTEN UTAMA --}}
    <div class="space-y-8">
        <h1 class="text-3xl font-bold text-gizila-dark dark:text-white mb-4 border-l-4 border-green-500 pl-4">{{ $title }}</h1>

        {{-- RINGKASAN & ARTIKEL TERBARU --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-800 dark:to-gray-900 border border-green-200 dark:border-gray-700 rounded-2xl p-6 shadow-md flex flex-col">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Total Seluruh Artikel</h2>
                <p class="text-6xl font-extrabold text-green-600 dark:text-gizila-dark">{{ $totalArticles }}</p>
                <a href="{{ route('admin.blog.index') }}" class="mt-4 inline-block text-gray-800 dark:text-white hover:underline text-sm">
                    ➜ Lihat semua artikel
                </a>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-800 dark:to-gray-900 border border-green-200 dark:border-gray-700 rounded-2xl p-6 shadow-md flex flex-col">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Artikel Terbaru</h2>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($articles as $article)
                        <li class="py-2">
                            <a href="{{ route('admin.blog.edit', $article) }}" class="font-medium text-green-700 dark:text-green-400 hover:underline">
                                {{ $article->title }}
                            </a>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $article->created_at->format('d M Y') }}</div>
                        </li>
                    @empty
                        <li class="text-gray-500 dark:text-gray-400 text-sm">Belum ada artikel.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- AREA 4 KOTAK GRAFIK (Struktur Final yang Benar) --}}
        <h2 class="text-2xl font-bold text-gizila-dark dark:text-white mt-10 border-l-4 border-green-500 pl-4">Statistik 12 Bulan Terakhir</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            
            <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-800 dark:to-gray-900 border border-green-200 dark:border-gray-700 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex-grow">
                    <canvas id="visitsChart" class="w-full"></canvas>
                </div>
                <div class="text-sm text-gray-600 dark:text-white mt-6 border-t pt-4">
                    {!! $summaryTexts['visits'] !!}
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-800 dark:to-gray-900 border border-green-200 dark:border-gray-700 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex-grow">
                    <canvas id="totalArticlesChart" class="w-full"></canvas>
                </div>
                <div class="text-sm text-gray-600 dark:text-white mt-6 border-t pt-4">
                     {!! $summaryTexts['total'] !!}
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-800 dark:to-gray-900 border border-green-200 dark:border-gray-700 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex-grow">
                     <canvas id="publishedArticlesChart" class="w-full"></canvas>
                </div>
                <div class="text-sm text-gray-600 dark:text-white mt-6 border-t pt-4">
                     {!! $summaryTexts['published'] !!}
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-800 dark:to-gray-900 border border-green-200 dark:border-gray-700 rounded-2xl p-6 shadow-md flex flex-col">
                <div class="flex-grow">
                    <canvas id="draftArticlesChart" class="w-full"></canvas>
                </div>
                <div class="text-sm text-gray-600 dark:text-white mt-6 border-t pt-4">
                     {!! $summaryTexts['draft'] !!}
                </div>
            </div>

        </div>
    </div>
    {{-- === SCRIPT JAVASCRIPT FINAL (METODE RENDER ULANG) === --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Siapkan variabel global untuk menyimpan semua instance grafik
        let chartInstances = [];

        // Fungsi utama untuk menggambar SEMUA grafik
        function renderAllCharts() {
            // Hancurkan semua grafik yang ada sebelum menggambar yang baru
            chartInstances.forEach(chart => chart.destroy());
            chartInstances = []; // Kosongkan array

            const chartData = @json($chartData);
            const labels = chartData.months;
    
            // Deteksi dark mode langsung di dalam fungsi
            const isDarkMode = document.documentElement.classList.contains('dark');

            // Tentukan warna berdasarkan mode saat fungsi ini dipanggil
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.15)' : 'rgba(0, 0, 0, 0.1)';
            const textColor = isDarkMode ? 'rgba(255, 255, 255, 0.7)' : '#6b7280';
    
            const createChartConfig = (chartLabels, data, label, color) => ({
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: label, data: data, borderColor: color, backgroundColor: `${color}33`,
                        fill: true, tension: 0.4, pointRadius: 0, pointHoverRadius: 5, pointHoverBackgroundColor: color,
                    }]
                },
                options: {
                    animation: false, // Matikan animasi agar tidak aneh saat render ulang
                    responsive: true, maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: textColor }, 
                            grid: { drawBorder: false, color: gridColor }, 
                        },
                        x: {
                            ticks: { color: textColor }, 
                            grid: { color: gridColor }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true, position: 'top', align: 'start',
                            labels: { boxWidth: 12, font: { size: 14, weight: 'bold' }, color: textColor }
                        }
                    },
                    interaction: { intersect: false, mode: 'index' },
                }
            });
    
            // Inisialisasi grafik dan simpan instance-nya
            chartInstances.push(new Chart(document.getElementById('visitsChart'), createChartConfig(labels, chartData.visitCounts, '📈 Kunjungan Website (Views)', '#3B82F6')));
            chartInstances.push(new Chart(document.getElementById('totalArticlesChart'), createChartConfig(labels, chartData.totalArticleCounts, '✍️ Total Artikel Dibuat', '#10B981')));
            chartInstances.push(new Chart(document.getElementById('publishedArticlesChart'), createChartConfig(labels, chartData.publishedArticleCounts, '✅ Artikel Diterbitkan', '#8B5CF6')));
            chartInstances.push(new Chart(document.getElementById('draftArticlesChart'), createChartConfig(labels, chartData.draftArticleCounts, '📝 Artikel Disimpan', '#F59E0B')));
        }

        // Tunggu hingga halaman dimuat, lalu gambar grafik untuk pertama kali
        document.addEventListener('DOMContentLoaded', renderAllCharts);
        const observer = new MutationObserver((mutations) => {
        for (const mutation of mutations) {
            if (mutation.attributeName === 'class') {
                renderAllCharts();
            }
        }
    });
    observer.observe(document.documentElement, { attributes: true });

        // --- FUNGSI UNTUK JAM REAL-TIME & SAPAAN (TIDAK ADA PERUBAHAN) ---
        function updateDashboardTime() {
            // ... (kode jam sama seperti sebelumnya, tidak perlu diubah)
            const now = new Date();
            const timeElement = document.getElementById("current-time");
            const greetingElement = document.getElementById("greeting");
            const wibHour = parseInt(now.toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit' }));

            let greetingText = "Halo";
            if (wibHour >= 0 && wibHour < 12) { greetingText = "Selamat Pagi"; } 
            else if (wibHour >= 12 && wibHour < 15) { greetingText = "Selamat Siang"; } 
            else if (wibHour >= 15 && wibHour < 18) { greetingText = "Selamat Sore"; } 
            else { greetingText = "Selamat Malam"; }
            
            greetingElement.textContent = greetingText;

            const timeOptions = { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' };
            timeElement.textContent = now.toLocaleTimeString('id-ID', timeOptions) + ' WIB';
        }

        setInterval(updateDashboardTime, 1000);
        updateDashboardTime();
    </script>
</x-layouts.admin>