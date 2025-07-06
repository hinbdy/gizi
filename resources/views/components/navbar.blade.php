<nav 
  x-data="{ scrolled: false }"
  x-init="scrolled = window.scrollY > 10; window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
  :class="scrolled 
    ? 'bg-gizila-radial dark:bg-gizila-dark transition-all ease-in-out duration-500' 
    : 'bg-transparent backdrop transition-all ease-in-out duration-500'"
  class="fixed top-0 left-0 right-0 z-50"
>
  <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

    {{-- Logo dan Search (Tidak Ada Perubahan) --}}
    <div class="flex items-center gap-4 w-full max-w-lg">
      <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
        <img src="{{ asset('assets/images/logo-gizila.png') }}" alt="Gizila Logo" class="h-12 w-auto object-contain dark">
      </a>

      <form method="GET" action="{{ route('blog.index') }}" class="hidden md:block w-full">
        <div 
        :class="scrolled
        ? 'flex items-center bg-white border border-gizila-dark rounded-full px-4 py-1 shadow-sm'
        : 'flex items-center bg-white border border-black rounded-full px-4 py-1 shadow-sm'">
          <img src="{{ asset('assets/images/icons/search-normal.svg') }}" class="w-4 h-4 mr-2" alt="Search">
          <input
            type="text"
            name="search"
            id="searchInput"
            placeholder="Cari artikel..."
            value="{{ request('search') }}"
            class="flex-1 bg-transparent focus:outline-none text-sm text-gray-700"
            autocomplete="off"
          />
        </div>
      </form>
    </div>

    {{-- Hamburger (mobile) (Tidak Ada Perubahan) --}}
    <button 
      class="lg:hidden text-2xl focus:outline-none mobile-menu-toggle transition"
      :class="scrolled ? 'text-gizila-dark' : 'text-black'">
      &#9776;
    </button>

    {{-- Menu Utama --}}
    <div class="hidden lg:flex gap-6 items-center mobile-menu transition-all duration-300 ease-in-out">
      <ul class="flex flex-col lg:flex-row gap-4 lg:gap-8 items-start lg:items-center text-base font-medium">
        {{-- HOME (Tidak Ada Perubahan) --}}
        <li>
          <a href="{{ route('home') }}" 
             class="border-b-2 transition"
             :class="scrolled 
               ? '{{ request()->routeIs('home') ? 'text-gizila-dark border-gizila-dark' : 'text-gizila-dark border-transparent hover:border-gizila-dark' }}'
               : '{{ request()->routeIs('home') ? 'text-black border-black' : 'text-black border-transparent hover:border-black' }}'">
            Home
          </a>
        </li>

        {{-- FITUR (Tidak Ada Perubahan) --}}
        <li class="relative group">
          <div class="flex items-center gap-1 cursor-pointer border-b-2 transition"
               :class="scrolled 
                 ? '{{ request()->routeIs('bmi.calculator') || request()->routeIs('nutrition.calculator') ? 'text-gizila-dark border-gizila-dark' : 'text-gizila-dark border-transparent hover:border-gizila-dark' }}'
                 : '{{ request()->routeIs('bmi.calculator') || request()->routeIs('nutrition.calculator') ? 'text-black border-black' : 'text-black border-transparent hover:border-black' }}'">
            Fitur-fitur Gizila
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </div>
          <div class="dropdown-menu absolute left-0 top-[calc(100%+24px)] mt-1 min-w-[320px] max-w-[320px] flex flex-col gap-0 px-3 py-2 rounded-xl bg-gizila-radial shadow-lg border border-gray-200 z-50 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 ease-out">
            @foreach ([ 
              ['icon' => 'imt.png', 'title' => 'Massa Tubuh', 'desc' => 'Hitung Indeks massa tubuh anda!', 'route' => route('bmi.calculator')], 
              ['icon' => 'kalkulator.png', 'title' => 'Gizi Harian', 'desc' => 'Hitung gizi harian anda!', 'route' => route('nutrition.calculator')], 
              ['icon' => 'pola-makan.png', 'title' => 'Artikel', 'desc' => 'Informasi dan edukasi seputar gizi.', 'route' => route('blog.index')], 
            ] as $item)
              <a href="{{ $item['route'] }}" class="flex items-start gap-3 px-3 py-3 border-b last:border-none border-gray-300 hover:bg-gizila-dark transition">
                <img src="{{ asset('assets/images/icons/' . $item['icon']) }}" alt="icon" class="w-7 h-7 mt-1">
                <div class="text-sm leading-tight">
                  <p class="font-semibold text-gray-800">{{ $item['title'] }}</p>
                  <p class="text-xs text-gray-600 whitespace-nowrap">{{ $item['desc'] }}</p>
                </div>
              </a>
            @endforeach
          </div>
        </li>

        {{-- === MULAI PERUBAHAN DI SINI === --}}
        <li>
          <a href="{{ route('blog.index') }}" 
             class="border-b-2 transition"
             {{-- Kita tambahkan `|| request()->routeIs('category.show')` di kedua kondisi --}}
             :class="scrolled 
               ? '{{ request()->routeIs('blog.index') || request()->routeIs('blog.show') || request()->routeIs('category.show') ? 'text-gizila-dark border-gizila-dark' : 'text-gizila-dark border-transparent hover:border-gizila-dark' }}'
               : '{{ request()->routeIs('blog.index') || request()->routeIs('blog.show') || request()->routeIs('category.show') ? 'text-black border-black' : 'text-black border-transparent hover:border-black' }}'">
            Blog
          </a>
        </li>
        {{-- === AKHIR PERUBAHAN === --}}

        {{-- ABOUT (Tidak Ada Perubahan) --}}
        <li>
          <a href="{{ route('about.index') }}" 
             class="border-b-2 transition"
             :class="scrolled 
               ? '{{ request()->routeIs('about.index') ? 'text-gizila-dark border-gizila-dark' : 'text-gizila-dark border-transparent hover:border-gizila-dark' }}'
               : '{{ request()->routeIs('about.index') ? 'text-black border-black' : 'text-black border-transparent hover:border-black' }}'">
            About
          </a>
        </li>
      </ul>

      {{-- LOGIN (Tidak Ada Perubahan) --}}
      <div class="flex gap-4 items-center mt-4 lg:mt-0">
        <a href="{{ route('login') }}" 
           class="px-4 py-2 rounded-lg border transition"
           :class="scrolled 
             ? 'border-gizila-dark text-gizila-dark hover:bg-gizila-dark hover:text-white' 
             : 'border-black text-black hover:bg-gizila-dark hover:text-white'">
          Log in
        </a>
      </div>
    </div>
  </div>
</nav>