<x-layout :title="$title ?? 'Kalkulator Gizi Harian'">
    <section class="min-h-screen bg-gizila-radial py-24 px-4">
        <div class="container mx-auto bg-[#d6f6e4] rounded-xl shadow-xl p-8">

           @php
                // ✅ PERBAIKAN: Menggunakan Storage::url() untuk membuat URL yang benar
                $foodsJson = json_encode($foods->map(fn($food) => [
                    'id' => $food->id,
                    'name' => $food->name,
                    'image_url' => $food->image_url ? Illuminate\Support\Facades\Storage::url($food->image_url) : asset('assets/images/foods/placeholder-food.png')
                ]));
             $initialMeals = [
                    'sarapan' => old('meals.sarapan', [['id' => now()->timestamp . rand(1000, 9999), 'food_id' => '', 'weight' => '', 'imagePreview' => asset('assets/images/placeholder-food.png')]]),
                    'makan_siang' => old('meals.makan_siang', [['id' => now()->timestamp . rand(1000, 9999), 'food_id' => '', 'weight' => '', 'imagePreview' => asset('assets/images/placeholder-food.png')]]),
                    'makan_malam' => old('meals.makan_malam', [['id' => now()->timestamp . rand(1000, 9999), 'food_id' => '', 'weight' => '', 'imagePreview' => asset('assets/images/placeholder-food.png')]])
                ];
                $initialMealsJson = json_encode($initialMeals);
            @endphp

            {{-- 'Otak' Alpine.js membungkus semua konten --}}
            <div x-data="nutritionCalculator({{ $foodsJson }})">
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gizila-dark">{{ $title ?? 'Kalkulator Gizi Harian' }}</h1>
                    <p class="text-gizila-dark mt-2">Cek kebutuhan gizi harian Anda untuk hidup lebih sehat.</p>
                </div>

                {{-- ========================================================== --}}
                {{-- ==   BAGIAN 1: FORMULIR INPUT (SELALU TAMPIL)          == --}}
                {{-- ========================================================== --}}
                
                {{-- Menampilkan Info TDEE jika ada session dari halaman BMI --}}
                @if(session('bmr') && session('bmi'))
                    <div id="hasil-bmi-info" class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-gray-200">
                        <h2 class="text-2xl font-bold text-center text-primary mb-4">Hasil Indeks Massa Tubuh (IMT) Anda</h2>
                        <p class="text-center text-gray-700">Total Kebutuhan Kalori Harian Anda (TDEE) adalah sekitar <strong class="text-primary text-lg">{{ session('bmr') }} kkal</strong>. Masukkan menu harian Anda di bawah untuk analisis lebih lanjut.</p>
                    </div>
                @endif

                {{-- Menampilkan Error Validasi --}}
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                        <p class="font-bold">Oops! Terjadi Kesalahan:</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulir Utama (SUDAH DIPERBAIKI) --}}
<form action="{{ route('nutrition.calculate') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @php
        $sesiMakan = [
            ['key' => 'sarapan', 'name' => 'Pilih Sarapan'], 
            ['key' => 'makan_siang', 'name' => 'Pilih Makan Siang'], 
            ['key' => 'makan_malam', 'name' => 'Pilih Makan Malam']
        ];
    @endphp
    <div class="space-y-12">
        @foreach ($sesiMakan as $sesi)
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <h2 class="text-2xl font-bold text-primary mb-6">{{ $sesi['name'] }}</h2>
            <template x-for="(item, index) in meals['{{ $sesi['key'] }}']" :key="index">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b pb-6 last:border-b-0 last:pb-0 last:mb-0">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <p class="font-bold text-lg text-gray-700" x-text="`Menu ${index + 1}`"></p>
                            <button type="button" @click="removeItem('{{ $sesi['key'] }}', index)" x-show="meals['{{ $sesi['key'] }}'].length > 1" class="text-red-600 hover:text-red-800 font-semibold text-sm">HAPUS</button>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cari Menu Makanan atau Minuman</label>
                            <select 
                                :name="`meals[{{ $sesi['key'] }}][${index}][food_id]`"
                                x-init="initTomSelect($el)"
                                x-model="item.food_id"
                                @change="updateImagePreview(item)"
                                required>
                                <option value="">-- Pilih atau ketik --</option>
                                @foreach($foods as $food)
                                <option value="{{ $food->id }}">{{ $food->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Porsi (gram)</label>
                            <input type="number" :name="`meals[{{ $sesi['key'] }}][${index}][weight]`" placeholder="Contoh: 150" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm" :value="`{{ old('meals.'.$sesi['key'].'.${index}.weight') }}`" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col items-center justify-center p-4 border-2 border-dashed rounded-lg h-full">
                            {{-- PERBAIKAN DI DUA BARIS DI BAWAH INI --}}
                            <input type="file" :name="`meals[{{ $sesi['key'] }}][${index}][image]`" accept="image/*" class="hidden" :id="`file_input_{{ $sesi['key'] }}_${index}`" @change="showUploadedImage($event, '{{$sesi['key']}}', index)">
                            <button type="button" @click="document.getElementById(`file_input_{{ $sesi['key'] }}_${index}`).click()" class="w-full bg-gizila-dark text-white py-2 px-4 rounded-md hover:bg-green-700 mb-2 text-sm">Upload Gambar</button>
                            
                            <button type="button" @click="openCamera('{{ $sesi['key'] }}', index)" class="w-full bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 text-sm">Ambil Gambar</button>
                            <p class="text-xs text-gray-500 mt-2 text-center">Opsional</p>
                        </div>
                        <div class="flex items-center justify-center p-2 border rounded-lg bg-gray-50 h-full">
                            <img :src="item.imagePreview" alt="Pratinjau Menu" class="max-h-36 max-w-full object-contain rounded">
                        </div>
                    </div>
                </div>
            </template>
            <button type="button" @click="addItem('{{ $sesi['key'] }}')" class="w-full border-2 border-dashed border-primary text-primary font-semibold py-3 px-4 rounded-lg hover:bg-primary-light transition">+ Tambah Menu Lainnya</button>
        </div>
        @endforeach
    </div>
    <div class="mt-12 text-center">
        <button type="submit" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-10 rounded-lg shadow-md">Analisis Asupan Gizi Saya</button>
    </div>
</form>

                {{-- ========================================================================= --}}
                {{-- ==   BAGIAN 2: HASIL ANALISIS (TAMPIL JIKA ADA DATA KALKULASI)         == --}}
                {{-- ========================================================================= --}}
                @if(isset($intake) && isset($recommendations))
                    <div id="hasil-analisis" class="container mx-auto px-4 pb-16 mt-16" x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'start' })">
                        <div class="text-center mb-10">
                            <h1 class="text-3xl md:text-4xl font-bold text-gizila-dark">Hasil Perhitungan Gizi Harian Anda</h1>
                            <p class="text-gizila-dark mt-2">Berikut adalah rincian asupan dan rekomendasi berdasarkan data yang Anda berikan.</p>
                        </div>

                        <div class="bg-white p-8 rounded-xl shadow-lg mb-8 border border-gray-200">
                            <h2 class="text-2xl font-bold text-primary mb-6 text-center">Ringkasan Kalori</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
                                <div>
                                    <p class="text-lg text-gray-600">Kebutuhan Kalori Harian Anda</p>
                                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ round($recommendations['calories']) }} <span class="text-xl">kkal</span></p>
                                </div>
                                <div>
                                    <p class="text-lg text-gray-600">Total Asupan Kalori Anda</p>
                                    <p class="text-4xl font-bold text-green-600 mt-2">{{ round($intake['calories']) }} <span class="text-xl">kkal</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-xl shadow-lg mb-8 border border-gray-200">
                            <h2 class="text-2xl font-bold text-primary mb-8 text-center">Analisis Makronutrien (Gram)</h2>
                            <div class="space-y-6">
                                @php $macros = ['Karbohidrat' => 'carbs', 'Protein' => 'protein', 'Lemak' => 'fat']; @endphp
                                @foreach($macros as $name => $key)
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-base font-medium text-gray-700">{{ $name }}</span>
                                        <span class="text-sm font-medium text-gray-700">Asupan: <span class="font-bold">{{ round($intake[$key]) }}g</span> / Rekomendasi: <span class="font-bold">{{ round($recommendations[$key]) }}g</span></span>
                                    </div>
                                    @php
                                        $percentage = ($recommendations[$key] > 0) ? (($intake[$key] / $recommendations[$key]) * 100) : 0;
                                        $percentage = min($percentage, 100); // Batasi maksimal 100%
                                    @endphp
                                    <div class="w-full bg-gray-200 rounded-full h-4">
                                        <div class="bg-green-500 h-4 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-xl shadow-lg mb-8 border border-gray-200">
                            <h2 class="text-2xl font-bold text-primary mb-6 text-center">Rekomendasi Menu Lainnya Untuk Anda</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach($menuRecommendations as $mealName => $foods)
                                <div class="border p-4 rounded-lg bg-gray-50">
                                    <h3 class="font-bold text-lg mb-3 text-gray-800">{{ $mealName }}</h3>
                                    <ul class="space-y-2 text-sm text-gray-600">
                                        @forelse($foods as $food)
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 mr-2 mt-1 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            <span>{{ $food->name }} (~{{$food->calories}} kkal)</span>
                                        </li>
                                        @empty
                                        <li>Tidak ada rekomendasi.</li>
                                        @endforelse
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                             <div class="lg:col-span-1 bg-yellow-100 border border-yellow-200 p-6 rounded-lg">
                                 <h3 class="font-bold text-lg text-yellow-800 mb-2">Disclaimer Penting</h3>
                                 <p class="text-sm text-yellow-700">Hasil dari kalkulator ini adalah estimasi dan bersifat sebagai informasi. Untuk kebutuhan gizi yang akurat dan penanganan medis, sangat disarankan untuk berkonsultasi langsung dengan dokter atau ahli gizi profesional.</p>
                             </div>
                             <div class="lg:col-span-2" x-data="{ openFaq: 1 }">
                                 <h3 class="text-2xl font-bold text-primary mb-4">Frequently Asked Questions (FAQ)</h3>
                                 <div class="space-y-3">
                                     @foreach($faq as $index => $item)
                                     <div class="border rounded-lg">
                                         <button @click="openFaq = openFaq === {{ $index+1 }} ? 0 : {{ $index+1 }} " class="w-full flex justify-between items-center p-4 text-left font-semibold text-gray-700">
                                             <span>{{ $item['question'] }}</span>
                                             <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': openFaq === {{ $index+1 }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                         </button>
                                         <div x-show="openFaq === {{ $index+1 }}" x-collapse class="p-4 pt-0 text-gray-600">{!! $item['answer'] !!}</div>
                                     </div>
                                     @endforeach
                                 </div>
                             </div>
                         </div>

                        <div class="text-center mt-12">
                            <a href="{{ route('nutrition.calculator') }}" class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-8 rounded-lg shadow-md">Hitung Ulang Gizi Harian</a>
                        </div>
                    </div>
                @endif

                {{-- ================================================================= --}}
                {{-- ==   BAGIAN POP-UP (Logika dan Gaya Baru)                      == --}}
                {{-- ================================================================= --}}
                @if (!session('bmi') && !isset($intake))
                    <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4" x-data="{ show: true }" x-show="show" style="display: none;">
                        <div class="bg-gizila-radial p-6 rounded-lg shadow-lg max-w-lg w-full text-center transition-all duration-300 transform"
                             x-show="show"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-90"
                             x-transition:enter-end="opacity-100 scale-100">

                            <h2 class="text-2xl font-semibold mb-4 text-green-700">Anda Belum Menghitung IMT</h2>
                            <p class="mb-6 text-green-700 font-semibold">Untuk hasil yang lebih akurat, silakan hitung IMT Anda terlebih dahulu.</p>
                            
                            <a href="{{ route('bmi.calculator') }}"
                               class="px-5 py-3 font-semibold rounded-lg border border-gizila-dark text-green-700 hover:bg-[#027527] hover:text-white transition">
                                 Hitung IMT Sekarang
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Modal Kamera --}}
                <div x-show="isCameraOpen" x-transition class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4" style="display: none;">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
                        <h3 class="text-xl font-bold mb-4">Ambil Foto Makanan</h3>
                        <video x-ref="videoElement" autoplay playsinline class="w-full rounded-md border bg-gray-200"></video>
                        <canvas x-ref="canvasElement" class="hidden"></canvas>
                        <div class="mt-4 text-right space-x-2">
                            <button @click="closeCamera()" type="button" class="px-4 py-2 bg-gray-200 rounded-md">Batal</button>
                            <button @click="capturePhoto()" type="button" class="px-4 py-2 bg-gizila-dark text-white rounded-md">Jepret Foto</button>
                        </div>
                    </div>
                </div>
            </div> {{-- Penutup untuk x-data --}}
        </div> {{-- Penutup untuk div .container --}}
    </section>

    {{-- Script diletakkan paling bawah --}}
    <script>
    function nutritionCalculator(foodsData) {
        return {
            foods: foodsData, // Berisi: id, name, image_url
            meals: {
                sarapan: [{ id: 1, food_id: '', weight: '', imagePreview: '{{ asset('assets/images/placeholder-food.png') }}' }],
                makan_siang: [{ id: 1, food_id: '', weight: '', imagePreview: '{{ asset('assets/images/placeholder-food.png') }}' }],
                makan_malam: [{ id: 1, food_id: '', weight: '', imagePreview: '{{ asset('assets/images/placeholder-food.png') }}' }]
            },
            nextId: 2,
            isCameraOpen: false,
            stream: null,
            activeCamera: { mealKey: null, index: null },

            // FUNGSI BARU: Untuk memperbarui gambar pratinjau
            updateImagePreview(currentItem) {
                // Jika tidak ada food_id yang dipilih, tampilkan placeholder
                if (!currentItem.food_id) {
                    currentItem.imagePreview = '{{ asset('assets/images/placeholder-food.png') }}';
                    return;
                }

                // Cari data makanan lengkap dari daftar 'foods' berdasarkan food_id yang dipilih
                let selectedFood = this.foods.find(f => f.id == currentItem.food_id);

                // Jika makanan ditemukan, ganti URL pratinjau
                if (selectedFood) {
                    currentItem.imagePreview = selectedFood.image_url;
                }
            },

            // FUNGSI INI KEMBALI DISEDERHANAKAN
            initTomSelect(element) {
                new TomSelect(element, {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    maxOptions: null, 
                });
            },

            // Sisa fungsi lainnya tetap sama
            addItem(mealKey) {
                this.meals[mealKey].push({ id: this.nextId++, food_id: '', weight: '', imagePreview: '{{ asset('assets/images/placeholder-food.png') }}' });
            },
            removeItem(mealKey, index) {
                if (this.meals[mealKey].length > 1) {
                    this.meals[mealKey].splice(index, 1);
                }
            },
            showUploadedImage(event, mealKey, index) {
                const reader = new FileReader();
                reader.onload = (e) => { this.meals[mealKey][index].imagePreview = e.target.result; };
                reader.readAsDataURL(event.target.files[0]);
            },
                openCamera(mealKey, index) {
                    this.isCameraOpen = true;
                    this.activeCamera = { mealKey, index };
                    this.$nextTick(async () => {
                        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                            try {
                                this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
                                this.$refs.videoElement.srcObject = this.stream;
                            } catch (error) {
                                console.error("Gagal mendapatkan stream video:", error);
                                alert("Tidak bisa mengakses kamera. Pastikan Anda memberikan izin pada browser.");
                                this.closeCamera();
                            }
                        } else {
                            alert("Browser Anda tidak mendukung fitur akses kamera.");
                        }
                    });
                },
                closeCamera() {
                    if (this.stream) {
                        this.stream.getTracks().forEach(track => track.stop());
                    }
                    this.isCameraOpen = false;
                },
                capturePhoto() {
                    const video = this.$refs.videoElement;
                    const canvas = this.$refs.canvasElement;
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                    const dataUrl = canvas.toDataURL('image/jpeg');
                    const { mealKey, index } = this.activeCamera;
                    this.meals[mealKey][index].imagePreview = dataUrl;
                    this.closeCamera();
                }
            }
        }
    </script>
    <x-footer/>
</x-layout>