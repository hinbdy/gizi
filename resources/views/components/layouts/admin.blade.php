@props(['title' => ''])

<x-layout :title="$title">
  <section class="min-h-screen bg-gizila-radial py-24 px-4">
    <div class="max-w-5xl mx-auto space-y-6">
{{-- resources/views/layouts/admin.blade.php --}}
@props(['title' => 'Admin'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="bg-gizila-radial min-h-screen font-sans">
    <div class="max-w-6xl mx-auto mt-6 p-6 bg-[#d6f6e4] shadow-xl rounded-2xl">
        {{-- Navbar --}}
        <div class="flex justify-between items-center mb-6 border-b-2 border-green-600 pb-4">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('assets/images/logo-gizi.png') }}" alt="Logo" class="w-8 h-8">
                <span class="text-green-800 font-bold text-xl">Admin Gizila</span>
            </div>
            <nav class="flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="text-green-600 hover:underline">🏠 Dashboard</a>
                <a href="{{ route('admin.blog.index') }}" class="text-green-600 hover:underline">📄 Artikel</a>
                <a href="{{ route('admin.profile') }}" class="text-green-600 hover:underline">👤 Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">🚪 Logout</button>
                </form>
            </nav>
        </div>

        {{-- Konten --}}
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
</x-layout>
