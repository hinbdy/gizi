@props(['title' => 'Admin Gizila'])
<!DOCTYPE html>
{{-- Menambahkan x-data dan :class untuk dark mode --}}
<html lang="id" x-data="{ isDarkMode: false }" x-init="isDarkMode = JSON.parse(localStorage.getItem('isDarkMode')) || false" :class="{ 'dark': isDarkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @stack('styles')
    @livewireStyles
</head>
<body class="font-sans antialiased">
    {{-- Menambahkan :class untuk mengubah latar sesuai dark mode --}}
    <div x-data="{ isSidebarOpen: true }" class="flex h-screen transition-colors duration-300" :class="isDarkMode ? 'bg-gizila-dark' : 'bg-gizila-radial'">
        
        <aside 
            :class="isSidebarOpen ? 'w-64' : 'w-20'" 
            class="relative flex-shrink-0 bg-white/5 backdrop-blur-lg border-r border-white flex flex-col transition-all duration-300 ease-in-out"
        >
            <button @click="isSidebarOpen = !isSidebarOpen" class="absolute top-12 -right-3 z-10 w-6 h-6 bg-gizila-radial border-grey rounded-full shadow-md flex items-center justify-center">
                <svg x-show="isSidebarOpen" class="w-4 h-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                <svg x-show="!isSidebarOpen" class="w-4 h-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </button>

            <div class="p-6 h-[65px] flex items-center" :class="isSidebarOpen ? 'justify-start' : 'justify-center'">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('assets/images/logo-gizi.png') }}" alt="Logo" class="h-8 w-auto flex-shrink-0">
                    <span x-show="isSidebarOpen" x-transition class="text-xl font-bold text-gizila-dark dark:text-white whitespace-nowrap">Admin Gizila</span>
                </a>
            </div>
            
            {{-- Sisa kode sidebar tidak diubah, hanya ditambahkan class dark mode --}}
            <nav class="mt-2 px-4 flex-grow">
                <div class="space-y-2">
                    <div>
                         {{-- PERUBAHAN DI SINI --}}
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gizila-radial dark:bg-gizila-dark-card text-gizila-dark dark:text-gizila-dark font-semibold' : 'text-black dark:text-black hover:bg-gizila-dark dark:hover:bg-gizila-radial' }}" :class="isSidebarOpen ? '' : 'justify-center'">
                            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
                            </svg>
                            <span x-show="isSidebarOpen" x-transition class="whitespace-nowrap">Dashboard</span>
                        </a>
                    </div>
                    <div class="pt-2">
                        {{-- PERUBAHAN DI SINI --}}
                        <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.blog.*') ? 'bg-gizila-radial dark:bg-gizila-dark-card text-gizila-dark dark:text-gizila-dark font-semibold' : 'text-black dark:text-black hover:bg-gizila-dark dark:hover:bg-gizila-radial' }}" :class="isSidebarOpen ? '' : 'justify-center'">
                            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            <span x-show="isSidebarOpen" x-transition class="whitespace-nowrap">Artikel</span>
                        </a>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-gizila-radial dark:bg-gizila-dark-card text-gizila-dark dark:text-gizila-dark font-semibold' : 'text-black dark:text-black hover:bg-gizila-dark dark:hover:bg-gizila-radial' }}" :class="isSidebarOpen ? '' : 'justify-center'">
                            {{-- Ikon Kategori --}}
                            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                            <span x-show="isSidebarOpen" x-transition class="whitespace-nowrap">Kategori Artikel</span>
                        </a>
                    </div>

                    <div class="pt-2">
                        {{-- PERUBAHAN DI SINI --}}
                         <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.profile') ? 'bg-gizila-radial dark:bg-gizila-dark-card text-gizila-dark dark:text-gizila-dark font-semibold' : 'text-black dark:text-black hover:bg-gizila-dark dark:hover:bg-gizila-radial' }}" :class="isSidebarOpen ? '' : 'justify-center'">
                           <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                           <span x-show="isSidebarOpen" x-transition class="whitespace-nowrap">Profil</span>
                        </a>
                    </div>
                </div>
            </nav>
            <div class="px-4 pb-4">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-red-500 dark:text-red-400 hover:bg-gizila-dark dark:hover:bg-gizila-radial" :class="isSidebarOpen ? '' : 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                        <span x-show="isSidebarOpen" x-transition>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- === KODE HEADER DIROMBAK TOTAL DI SINI === --}}
            <header class="bg-transparent border-b border-black/10 dark:border-white/10">
                <div class="px-6 py-3 flex justify-end items-center">
                    <div class="flex items-center gap-4">
                        {{-- Tombol Dark Mode --}}
                        <button @click="isDarkMode = !isDarkMode; localStorage.setItem('isDarkMode', JSON.stringify(isDarkMode))" class="text-gizila-dark dark:text-white p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/10">
                            <svg x-show="!isDarkMode" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            <svg x-show="isDarkMode" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                        </button>

                        {{-- Garis Pemisah --}}
                        <div class="w-px h-6 bg-black/10 dark:bg-white/10"></div>

                        {{-- Dropdown Profil --}}
                        <div x-data="{ isProfileOpen: false }" class="relative">
                            {{-- Tombol Trigger Dropdown --}}
                            <button @click="isProfileOpen = !isProfileOpen" class="flex items-center gap-2">
                                <img class="h-8 w-8 rounded-full object-cover ring-2 ring-transparent hover:ring-gizila-dark/50 dark:hover:ring-white/50" 
                                     src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random&color=fff' }}" 
                                     alt="User avatar">
                            </button>
                            {{-- Menu Dropdown --}}
                            <div 
                                x-show="isProfileOpen" 
                                @click.away="isProfileOpen = false" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-10 border border-gray-200 dark:border-gray-700"
                                style="display: none;"
                            >
                                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Pengaturan</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 dark:text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="p-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
    @livewireScripts
</body>
</html>