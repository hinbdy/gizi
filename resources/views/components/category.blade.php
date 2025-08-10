<section id="Category" class="py-20">
    <div class="container max-w-7xl mx-auto flex flex-col items-center gap-12">
        {{-- Judul Bagian Fitur --}}
        <div class="mx-auto max-w-2xl text-center">
             <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
             <span class="relative inline-block">
                Jelajahi Fitur Unggulan <span class="text-gizila-dark">Gizila</span>
            <span class="absolute bottom-[-8px] left-0 h-1.5 w-full origin-left scale-x-0 transform bg-gizila-dark transition-transform duration-500 ease-in-out animate-draw-line"></span>
             </span>
         </h2>
            <p class="mt-2 text-lg leading-8 text-gray-600">
                Semua yang kamu butuhkan untuk memantau gizi harian dan kesehatan.
            </p>
        </div>

        {{-- Container untuk Kartu Fitur --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-8 w-full px-4 sm:px-8 md:px-12">
            
            @foreach([
                ['icon' => 'imt.png', 'title' => 'Kalkulator BMI', 'desc' => 'Hitung indeks massa tubuh kamu !', 'route' => route('bmi.calculator')],
                ['icon' => 'kalkulator.png', 'title' => 'Gizi Harian', 'desc' => 'Hitung kebutuhan gizi harian kamu !', 'route' => route('nutrition.calculator')],
                ['icon' => 'pola-makan.png', 'title' => 'Artikel', 'desc' => 'Informasi dan edukasi seputar gizi.', 'route' => route('blog.index')],
            ] as $i => $feature)
                <a 
                    href="{{ $feature['route'] }}"
                    {{-- Atribut x-data, x-intersect, dan :class dihapus untuk memastikan kartu tampil --}}
                    class="group block rounded-3xl p-6 sm:p-8 md:p-10 shadow-xl border border-gray-200 dark:border-gray-700 bg-gizila-dark hover:shadow-2xl hover:-translate-y-2 transform transition-all duration-500"
                >
                    <div class="flex flex-col items-center text-center gap-4 sm:gap-5">
                        <img src="{{ asset('assets/images/icons/' . $feature['icon']) }}" alt="{{ $feature['title'] }}"
                            class="w-20 h-20 sm:w-24 sm:h-24 transition-transform duration-300 group-hover:scale-110" />
                        
                        <h3 class="text-lg sm:text-xl font-bold text-white">{{ $feature['title'] }}</h3>
                        
                        <p class="text-sm sm:text-base text-white/80">
                            {{ $feature['desc'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>