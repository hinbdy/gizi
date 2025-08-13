{{-- File: resources/views/components/navbar.blade.php --}}
<nav 
    x-data="{ scrolled: false, mobileMenuOpen: false }"
    x-init="
        scrolled = window.scrollY > 10;
        window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })
    "
    :class="scrolled || mobileMenuOpen ? 'bg-white/90 backdrop-blur-sm shadow-md' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex justify-between items-center">

            {{-- Logo + Pencarian Desktop --}}
            <div class="flex items-center gap-4">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="shrink-0">
                    <img src="{{ asset('assets/images/logo-gizila.png') }}" alt="Gizila Logo" class="h-12 w-auto object-contain">
                </a>

                {{-- Form Pencarian Desktop --}}
                <form method="GET" action="{{ route('blog.index') }}" class="hidden lg:block w-full max-w-xs">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari judul artikel..."
                            value="{{ request('search') }}"
                            class="w-full bg-gizila-radial border-gray-300 rounded-full py-2 pl-4 pr-10 focus:ring-2 focus:ring-gizila-dark focus:border-gizila-dark transition"
                            autocomplete="off"
                        />
                        <button type="submit" class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 hover:text-gizila-dark">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Menu kanan --}}
            <div class="flex items-center">
                {{-- Hamburger Mobile --}}
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden text-2xl text-gray-700 focus:outline-none"
                    aria-label="Toggle Menu"
                >
                    <span x-show="!mobileMenuOpen">&#9776;</span>
                    <span x-show="mobileMenuOpen" x-cloak>&times;</span>
                </button>

                {{-- Menu Desktop --}}
                <div class="hidden lg:flex items-center gap-8">
                    <x-navbar-links />
                </div>
            </div>

        </div>
    </div>

    {{-- Panel Mobile --}}
    <div 
        x-show="mobileMenuOpen"
        x-cloak
        @click.away="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="lg:hidden absolute top-full left-0 w-full bg-white shadow-lg"
    >
        <div class="p-5 flex flex-col gap-4">

            {{-- Form Pencarian Mobile dengan Animasi --}}
            <div
                x-show="mobileMenuOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
            >
                <form method="GET" action="{{ route('blog.index') }}">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari judul artikel..."
                            value="{{ request('search') }}"
                            class="w-full bg-gizila-radial border-gray-300 rounded-full py-2 pl-4 pr-10 focus:ring-2 focus:ring-gizila-dark focus:border-gizila-dark transition"
                            autocomplete="off"
                        />
                        <button type="submit" class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 hover:text-gizila-dark">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Link Navigasi --}}
            <x-navbar-links />
        </div>
    </div>
</nav>
