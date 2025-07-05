<section id="Category"
  x-data="{ showFeatures: false, scrolled: false }"
  x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 100 })"
  class="py-20"
>
  <div class="container max-w-[1130px] mx-auto flex flex-col items-center gap-12">

    {{-- Tombol Jelajahi --}}
    <template x-if="scrolled">
      <button
        @click="showFeatures = !showFeatures"
        class="px-6 py-3 bg-gizila-dark text-white font-semibold rounded-full hover:bg-green-800 transition-all duration-300 text-sm sm:text-base"
        x-text="showFeatures ? 'Tutup Fitur Gizila' : 'Jelajahi Fitur Gizila'"
      ></button>
    </template>

    {{-- Daftar Fitur --}}
    <div 
      x-show="showFeatures"
      x-transition:enter="transition ease-out duration-500"
      x-transition:enter-start="opacity-0 translate-y-6"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 translate-y-6"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-8 w-full px-4 sm:px-8 md:px-12"
    >
      @foreach([
        ['icon' => 'imt.png', 'title' => 'Kalkulator BMI', 'desc' => 'Hitung indeks massa tubuh anda!', 'route' => route('bmi.calculator')],
        ['icon' => 'kalkulator.png', 'title' => 'Gizi Harian', 'desc' => 'Hitung kebutuhan gizi harian anda!', 'route' => route('nutrition.calculator')],
        ['icon' => 'pola-makan.png', 'title' => 'Artikel', 'desc' => 'Informasi dan edukasi seputar gizi.', 'route' => route('blog.index')],
      ] as $i => $feature)
        <a 
          href="{{ $feature['route'] }}"
          x-intersect="setTimeout(() => $el.classList.add('fade-in'), {{ $i * 200 }})"
          class="group block rounded-3xl p-6 sm:p-8 md:p-10 shadow-xl border border-gray-200 dark:border-gray-700 bg-gizila-dark hover:shadow-2xl hover:-translate-y-2 transform transition-all duration-500 opacity-0"
        >
          <div class="flex flex-col items-center text-center gap-4 sm:gap-5">
            <img src="{{ asset('assets/images/icons/' . $feature['icon']) }}" alt="{{ $feature['title'] }}"
              class="w-20 h-20 sm:w-24 sm:h-24 transition-transform duration-300 group-hover:scale-110" />
            <h3 class="text-lg sm:text-xl font-bold text-white-800 text-white">{{ $feature['title'] }}</h3>
            <p class="text-sm sm:text-base text-white-700 text-white whitespace-nowrap overflow-hidden text-ellipsis max-w-[260px] sm:max-w-[300px]">
              {{ $feature['desc'] }}
            </p>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
