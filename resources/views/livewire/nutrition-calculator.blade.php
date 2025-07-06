<section class="min-h-screen bg-gizila-radial py-24 px-4">
    <div wire:loading.class.delay="opacity-50 blur-sm">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-6 sm:p-8">
            <h1 class="text-3xl md:text-4xl font-bold text-center text-gizila-dark mb-2">
                Kalkulator Gizi Harian
            </h1>
            <p class="text-center text-gray-600 mb-8">Masukkan menu makanan Anda untuk mengetahui total asupan kalori harian.</p>

            {{-- Tampilan Kebutuhan Kalori (BMR) --}}
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-8">
                <p class="text-sm font-medium text-green-800">Kebutuhan Kalori Harian Anda:</p>
                <p class="text-2xl font-bold text-green-700">{{ $bmr }} kkal</p>
            </div>

            {{-- Form Utama --}}
            <div class="space-y-8">
                @php
                    $porsiOptions = [50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 350, 400, 500];
                @endphp

                @foreach($meals as $mealName => $menus)
                <div class="bg-gray-50 p-6 rounded-xl border shadow-sm">
                    <h3 class="text-xl font-bold mb-6 text-gizila-dark">{{ $mealName }}</h3>
                    
                    <div class="space-y-6">
                        @foreach($menus as $index => $menu)
                        <div wire:key="menu-{{ $mealName }}-{{ $index }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start pb-6 border-b last:border-b-0">
                            
                            {{-- KOLOM GAMBAR MAKANAN DINAMIS --}}
                            <div class="md:col-span-4">
                                <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 border-2 border-dashed relative overflow-hidden">
                                    @if (!empty($menu['food_id']) && ($foodImage = $allFoods->find($menu['food_id'])->image_url))
                                        <img src="{{ $foodImage }}" alt="Gambar Makanan" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center">
                                            <i class="fas fa-image text-3xl"></i>
                                            <p class="text-xs mt-1">Gambar Makanan</p>
                                        </div>
                                    @endif
                                </div>
                                {{-- Tombol Upload & Ambil Foto --}}
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                     <button type="button" class="w-full bg-blue-500 text-white px-3 py-1.5 rounded-md font-semibold text-xs hover:bg-blue-600">Upload</button>
                                     <button type="button" class="w-full bg-gray-600 text-white px-3 py-1.5 rounded-md font-semibold text-xs hover:bg-gray-700">Kamera</button>
                                </div>
                            </div>

                            {{-- KOLOM INPUT MAKANAN & PORSI --}}
                            <div class="md:col-span-8 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm mb-1 font-medium text-gray-700">Pilih Menu</label>
                                        {{-- `wire:model.live` akan mengupdate tampilan secara real-time --}}
                                        <select wire:model.live="meals.{{ $mealName }}.{{ $index }}.food_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="">-- Cari Makanan --</option>
                                            @foreach($allFoods as $food)
                                            <option value="{{ $food->id }}">{{ $food->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1 font-medium text-gray-700">Pilih Porsi</label>
                                        <select wire:model.live="meals.{{ $mealName }}.{{ $index }}.grams" class="w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="">-- Pilih Porsi --</option>
                                            @foreach($porsiOptions as $porsi)
                                                <option value="{{ $porsi }}">{{ $porsi }} Gram</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Tombol Remove akan muncul jika ada lebih dari 1 menu --}}
                                @if(count($menus) > 1)
                                <div class="text-right">
                                    <button type="button" wire:click="removeMenu('{{ $mealName }}', {{ $index }})" class="bg-red-500 text-white px-3 py-1 rounded-md font-semibold text-xs hover:bg-red-600">
                                        Remove
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- Tombol Tambah Menu --}}
                    <button type="button" wire:click="addMenu('{{ $mealName }}')" class="mt-4 text-sm font-semibold text-green-600 hover:text-green-800">
                        + Tambah Menu Lainnya
                    </button>
                </div>
                @endforeach
            </div>

            {{-- Hasil Perhitungan Live (akan otomatis terupdate) --}}
            <div id="hasil-gizi" class="mt-12">
                <h2 class="text-2xl font-bold text-center text-gizila-dark mb-6">Total Asupan Gizi Anda</h2>
                {{-- ... (kode progress bar, sama seperti sebelumnya) ... --}}
            </div>
        </div>
    </div>
</section>