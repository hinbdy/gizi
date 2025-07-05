<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Gizila' }}</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
</head>
<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-white font-poppins">

  {{-- Navbar --}}
   <x-navbar />

  {{-- Konten --}}
  <main class="min-h-screen pt-[80px]"> {{-- Padding top untuk menghindari ketiban navbar --}}
    {{ $slot }}
  </main>

  {{-- Footer --}}
 <x-footer />

</body>
</html>
