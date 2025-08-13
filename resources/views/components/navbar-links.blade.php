{{-- File: resources/views/components/navbar-links.blade.php --}}
<ul class="flex flex-col lg:flex-row gap-4 lg:gap-8 items-start lg:items-center text-base font-medium">
    {{-- Home --}}
    <li>
        <a href="{{ route('home') }}" 
           class="border-b-2 transition"
           :class="scrolled 
               ? '{{ request()->routeIs('home') ? 'text-gizila-dark border-gizila-dark' : 'text-gizila-dark border-transparent hover:border-gizila-dark' }}'
               : '{{ request()->routeIs('home') ? 'text-black border-black' : 'text-black border-transparent hover:border-black' }}'">
            Home
        </a>
    </li>

    {{-- Fitur --}}
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
        {{-- Dropdown Desktop --}}
        <div class="dropdown-menu absolute left-0 top-[calc(100%+24px)] min-w-max flex flex-col px-3 py-2 rounded-xl bg-gizila-radial shadow-lg border border-gray-200 z-50 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 ease-out">
            @foreach ([ 
                ['icon' => 'imt.png', 'title' => 'Massa Tubuh', 'desc' => 'Hitung Indeks massa tubuh anda!', 'route' => route('bmi.calculator')], 
                ['icon' => 'kalkulator.png', 'title' => 'Gizi Harian', 'desc' => 'Hitung gizi harian anda!', 'route' => route('nutrition.calculator')], 
                ['icon' => 'pola-makan.png', 'title' => 'Artikel Gizila', 'desc' => 'Informasi dan edukasi.', 'route' => route('blog.index')], 
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

    {{-- Blog --}}
    <li>
        <a href="{{ route('blog.index') }}" 
           class="border-b-2 transition"
           :class="scrolled 
               ? '{{ request()->routeIs('blog.index') || request()->routeIs('blog.show') || request()->routeIs('category.show') ? 'text-gizila-dark border-gizila-dark' : 'text-gizila-dark border-transparent hover:border-gizila-dark' }}'
               : '{{ request()->routeIs('blog.index') || request()->routeIs('blog.show') || request()->routeIs('category.show') ? 'text-black border-black' : 'text-black border-transparent hover:border-black' }}'">
            Blog
        </a>
    </li>

    {{-- About --}}
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
