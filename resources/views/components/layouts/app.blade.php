@props(['title' => ''])
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Gizila' }}</title>
  
  {{-- Google Fonts (Tetap) --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  {{-- Font Awesome dari CDN (Tetap) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  {{-- CSS untuk library eksternal bisa ditambahkan di sini jika perlu --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
  
  
  {{-- --- PERBAIKAN UTAMA ADA DI SINI --- --}}
  {{-- Memanggil semua CSS dan JS utama Anda melalui satu perintah Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  {{-- Alpine JS (dihapus dari sini karena akan kita panggil lewat app.js) --}}
  @stack('styles')
  @livewireStyles
</head>
<body class="text-belibang-grey font-poppins relative overflow-x-hidden">

  {{-- LATAR RADIAL HIJAU (Tetap) --}}
  <div class="absolute top-0 left-0 w-full h-full -z-[1] bg-[radial-gradient(circle_at_top_left,_#b1fcb5_0%,_transparent_70%)] pointer-events-none"></div>

  {{-- Navbar (Tetap) --}}
  <x-navbar />

  {{-- Konten Halaman (Tetap) --}}
  <main>
    {{ $slot }}
  </main>

  {{-- --- BAGIAN SCRIPT DI BAWAH INI DIRAPIKAN --- --}}
  {{-- Hanya @livewireScripts yang perlu ada di sini sebelum body ditutup.
       Semua script lain akan dikelola oleh app.js yang dipanggil Vite di <head>. --}}
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
  @stack('scripts')
  @livewireScripts
</body>
</html>