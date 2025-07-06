<x-layout :title="$title ?? 'Kalkulator Gizi Harian'">
    @push('styles')
    <style>
        /* Style untuk accordion FAQ */
        .faq-question::after {
            content: '\25BC'; /* Down arrow */
            font-size: 0.8rem;
            transition: transform 0.3s ease;
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
        }
        .faq-question[aria-expanded="true"]::after {
            transform: translateY(-50%) rotate(180deg); /* Up arrow */
        }
        /* Style untuk progress bar custom */
        @property --progress-value {
            syntax: '<integer>';
            initial-value: 0;
            inherits: false;
        }
        .progress-bar-animated {
            animation: progress 1s 0.5s ease-out forwards;
        }
        @keyframes progress {
            from { --progress-value: 0; }
            to { --progress-value: var(--progress-end-value); }
        }
    </style>
    @endpush

    <section class="min-h-screen bg-gizila-radial py-24 px-4">
        <div class="max-w-5xl mx-auto space-y-12">
            
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-center text-gizila-dark mb-4">Kalkulator Kebutuhan Gizi</h1>
                <p class="text-center text-gray-600 mb-6 max-w-2xl mx-auto">Masukkan menu makanan harian Anda di bawah ini untuk menganalisis asupan gizi dan dapatkan rekomendasi menu yang sesuai untuk Anda.</p>
                @if(session('bmr'))
                    <div class="inline-block bg-white border-2 border-green-600 p-4 rounded-xl shadow-lg">
                        <p class="text-sm font-medium text-green-800">Estimasi Kebutuhan Kalori Harian Anda:</p>
                        <p class="text-3xl font-bold text-green-700">{{ session('bmr') }} kkal</p>
                    </div>
                @else
                    {{-- Jika BMR belum ada, redirect ke kalkulator BMI --}}
                    <script> window.location.href = "{{ url('/kalkulator-massa-tubuh') }}"; </script>
                @endif
            </div>

            <div id="form-gizi-harian" class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                <form method="POST" action="{{ url('/kalkulator-gizi-harian/hitung') }}" class="space-y-8">
                    @csrf
                    <h2 class="text-2xl font-bold text-gizila-dark border-b-2 pb-3 mb-6">📝 Catat Makanan Anda</h2>
                    @php $sesi = [['nama' => 'Sarapan', 'icon' => 'fa-sun'], ['nama' => 'Makan Siang', 'icon' => 'fa-utensils'], ['nama' => 'Makan Malam', 'icon' => 'fa-moon']]; @endphp

                    @foreach($sesi as $key => $s)
                    <div class="bg-gray-50 p-6 rounded-xl border">
                        <h3 class="text-xl font-bold mb-4 text-gizila-dark flex items-center gap-3"><i class="fas {{ $s['icon'] }}"></i>{{ $s['nama'] }}</h3>
                        <div class="space-y-4" id="menu-container-{{ $key }}">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end menu-row">
                                <div class="md:col-span-6">
                                    <label class="block text-sm mb-1 font-medium text-gray-700">Pilih Menu</label>
                                    <select name="foods[{{ $key }}][]" class="makanan-select w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">-- Cari Makanan --</option>
                                        @foreach($foods as $food)
                                            <option value="{{ $food->id }}">{{ $food->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-4">
                                    <label class="block text-sm mb-1 font-medium text-gray-700">Porsi (gram)</label>
                                    <input type="number" name="weights[{{ $key }}][]" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: 150">
                                </div>
                                <div class="md:col-span-2 text-right">
                                    {{-- Placeholder untuk tombol hapus, agar layout tidak bergeser --}}
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="tambahBaris({{ $key }})" class="mt-4 text-sm font-semibold text-green-600 hover:text-green-800 transition">+ Tambah Menu</button>
                    </div>
                    @endforeach

                    <div class="text-center pt-6 border-t">
                        <button type="submit" class="px-10 py-4 bg-green-600 text-white rounded-full font-bold text-lg hover:bg-green-700 transition-transform hover:scale-105 shadow-lg">
                            Lihat Hasil Analisis & Rekomendasi
                        </button>
                    </div>
                </form>
            </div>
            
            @isset($intake)
                <div id="hasil-analisis" class="space-y-12">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                        <h2 class="text-2xl font-bold text-gizila-dark mb-6">Hasil Analisis Asupan Gizi Anda</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div class="text-center">
                                <p class="text-gray-600">Asupan Kalori Harian Anda</p>
                                <p class="text-6xl font-bold text-green-700 my-2">{{ number_format($intake['calories'], 0) }}</p>
                                <p class="text-gray-600">dari target <span class="font-bold">{{ number_format($recommendations['calories'], 0) }}</span> kkal</p>
                                @php
                                    $calorieDiff = $intake['calories'] - $recommendations['calories'];
                                    $verdict = abs($calorieDiff) < ($recommendations['calories'] * 0.1) 
                                        ? ['text' => 'Sudah Cukup Baik!', 'color' => 'green']
                                        : ($calorieDiff > 0 
                                            ? ['text' => 'Berlebih', 'color' => 'yellow']
                                            : ['text' => 'Kurang', 'color' => 'red']);
                                @endphp
                                <div class="mt-4 inline-block px-4 py-2 rounded-full bg-{{$verdict['color']}}-100 text-{{$verdict['color']}}-800 font-semibold">
                                    {{ $verdict['text'] }}
                                </div>
                            </div>
                            <div class="space-y-5">
                                @foreach(['protein' => 'Protein', 'fat' => 'Lemak', 'carbs' => 'Karbohidrat'] as $key => $label)
                                    @php
                                        $persen = ($recommendations[$key] > 0) ? min(100, ($intake[$key] / $recommendations[$key]) * 100) : 0;
                                        $color = ($key == 'protein') ? 'blue' : (($key == 'fat') ? 'yellow' : 'red');
                                    @endphp
                                    <div>
                                        <div class="flex justify-between items-end mb-1">
                                            <span class="text-base font-semibold text-gray-800">{{ $label }}</span>
                                            <span class="text-sm font-medium text-gray-600">
                                                <span class="font-bold text-{{$color}}-600">{{ number_format($intake[$key], 0) }}g</span> / {{ number_format($recommendations[$key], 0) }}g
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="bg-{{$color}}-500 h-3 rounded-full" style="width: {{ $persen }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                        <h2 class="text-2xl font-bold text-gizila-dark mb-6">Rekomendasi Menu Seimbang Untuk Anda</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($menuRecommendations as $mealName => $foods)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="font-bold text-center text-gray-800 mb-3">{{ $mealName }}</h3>
                                    <div class="space-y-3">
                                        @forelse($foods as $food)
                                            <div class="text-sm p-2 bg-white rounded shadow-sm text-center">
                                                <p class="font-semibold">{{ $food->name }}</p>
                                                <p class="text-xs text-gray-500">~{{ $food->calories }} kkal / 100g</p>
                                            </div>
                                        @empty
                                            <p class="text-xs text-gray-500 text-center">Tidak ada rekomendasi.</p>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-r-lg">
                        <h3 class="font-bold">Disclaimer</h3>
                        <p class="text-sm">Hasil dari kalkulator ini adalah estimasi dan bersifat sebagai informasi. Hasil ini tidak menggantikan saran medis profesional. Untuk mendapatkan rekomendasi gizi yang akurat dan sesuai dengan kondisi kesehatan Anda, sangat disarankan untuk berkonsultasi dengan dokter atau ahli gizi.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                        <h2 class="text-2xl font-bold text-gizila-dark mb-6">Tanya Jawab (FAQ)</h2>
                        <div class="space-y-4" x-data="{ openFaq: null }">
                            @foreach($faq as $index => $item)
                                <div>
                                    <h3>
                                        <button
                                            @click="openFaq = (openFaq === {{ $index }} ? null : {{ $index }})"
                                            :aria-expanded="openFaq === {{ $index }}"
                                            type="button"
                                            class="faq-question relative flex items-center justify-between w-full text-left font-semibold p-4 rounded-lg bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            <span>{{ $item['question'] }}</span>
                                        </button>
                                    </h3>
                                    <div x-show="openFaq === {{ $index }}" x-transition class="mt-2 p-4 text-gray-700 prose max-w-none">
                                        {!! $item['answer'] !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endisset

        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi Select2 untuk semua select yang ada saat load
            $('.makanan-select').select2({
                placeholder: "-- Cari Makanan --",
                width: '100%',
                allowClear: true,
            });

            // Jika ada hasil, scroll ke sana
            const hasilAnalisis = document.getElementById('hasil-analisis');
            if (hasilAnalisis) {
                setTimeout(() => {
                    hasilAnalisis.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300);
            }
        });

        // Template HTML untuk baris baru
        const foodsJson = @json($foods->map(fn($f) => ['id' => $f->id, 'name' => $f->name]));
        const optionsHtml = foodsJson.map(food => `<option value="${food.id}">${food.name}</option>`).join('');

        const newRowTemplate = (sesiKey) => `
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end menu-row pt-4 mt-4 border-t">
                <div class="md:col-span-6">
                    <select name="foods[${sesiKey}][]" class="makanan-select w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Cari Makanan --</option>
                        ${optionsHtml}
                    </select>
                </div>
                <div class="md:col-span-4">
                    <input type="number" name="weights[${sesiKey}][]" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Porsi (gram)">
                </div>
                <div class="md:col-span-2 text-right">
                    <button type="button" onclick="this.closest('.menu-row').remove()" class="text-red-500 hover:text-red-700 font-semibold text-sm">Hapus</button>
                </div>
            </div>
        `;

        function tambahBaris(sesiKey) {
            const container = document.getElementById(`menu-container-${sesiKey}`);
            const newRow = document.createElement('div');
            newRow.innerHTML = newRowTemplate(sesiKey);
            
            // Perlu attach element ke DOM dulu sebelum inisialisasi select2
            container.appendChild(newRow.firstElementChild);

            // Inisialisasi select2 pada baris yang baru ditambahkan
            $(container).find('.makanan-select:last').select2({
                placeholder: "-- Cari Makanan --",
                width: '100%',
                allowClear: true,
            });
        }
    </script>
    @endpush
</x-layout>