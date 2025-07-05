@props(['title' => ''])
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Gizila' }}</title>
   {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  {{-- Tailwind CSS via Vite --}}
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')

  @livewireStyles

{{-- Flickity (carousel) --}}
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css" />
 {{-- Select2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{{-- GANTI DENGAN DUA BARIS INI --}}
<script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


{{-- jQuery (WAJIB sebelum Select2) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
@stack('styles')
</head>
<body class="text-belibang-grey font-poppins relative overflow-x-hidden">

  {{-- LATAR RADIAL HIJAU --}}
  <div class="absolute top-0 left-0 w-full h-full -z-[1] bg-[radial-gradient(circle_at_top_left,_#b1fcb5_0%,_transparent_70%)] pointer-events-none"></div>

  {{-- Navbar --}}
  <x-navbar />

  {{-- Konten Halaman --}}
  <main>
    {{ $slot }}
  </main>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
  });
</script>

  {{-- FontAwesome --}}
  <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>

{{-- search --}}
<script>
  const input = document.getElementById('searchInput');
  const resultsBox = document.getElementById('searchResults');

  input.addEventListener('input', async function () {
    const query = this.value;

    if (query.length < 2) {
      resultsBox.innerHTML = '';
      resultsBox.classList.add('hidden');
      return;
    }

    try {
      const response = await fetch(`/api/search-articles?q=${query}`);
      const results = await response.json();

      if (results.length > 0) {
        resultsBox.innerHTML = results.map(article => `
          <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
            <a href="/artikel/${article.slug}" class="block text-sm text-gray-800">${article.title}</a>
          </li>
        `).join('');
        resultsBox.classList.remove('hidden');
      } else {
        resultsBox.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500">Tidak ada hasil</li>';
        resultsBox.classList.remove('hidden');
      }
    } catch (err) {
      console.error(err);
    }
  });

  document.addEventListener('click', function (e) {
    if (!resultsBox.contains(e.target) && e.target !== input) {
      resultsBox.classList.add('hidden');
    }
  });
</script>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.directive('intersect', (el, { expression }, { evaluateLater }) => {
      const evaluate = evaluateLater(expression);

      const observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
          evaluate();
        }
      }, { threshold: 0.1 });

      observer.observe(el);
    });
  });
</script>


  {{-- JS untuk dropdown & hamburger --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const mobileToggle = document.querySelector('.mobile-menu-toggle');
      const mobileMenu = document.querySelector('.mobile-menu');

      if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
          mobileMenu.classList.toggle('hidden');
        });
      }

      const dropdownBtn = document.querySelector('.menu-button');
      const dropdown = document.querySelector('.dropdown-menu');

      if (dropdownBtn && dropdown) {
        dropdownBtn.addEventListener('click', function (e) {
          dropdown.classList.toggle('hidden');
          dropdown.classList.toggle('opacity-0');
          dropdown.classList.toggle('translate-y-2');
        });

        document.addEventListener('click', function (e) {
          if (!dropdown.contains(e.target) && !dropdownBtn.contains(e.target)) {
            dropdown.classList.add('hidden', 'opacity-0', 'translate-y-2');
          }
        });

        dropdown.querySelectorAll('a').forEach(link => {
          link.addEventListener('click', () => {
            dropdown.classList.add('hidden', 'opacity-0', 'translate-y-2');
          });
        });
      }
    });
  </script>

  <script src="{{ mix('js/app.js') }}"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script>
  document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi semua select makanan jadi Select2
    $('.makanan-select').select2({
      placeholder: "-- Pilih Makanan --",
      allowClear: true,
      width: '100%'
    });
  }); --}}
</script>
<script src="{{ mix('js/password-toggle.js') }}"></script>

  {{-- <script>
    function scrollToHasil() {
      setTimeout(() => {
        document.getElementById('hasil-gizi')?.scrollIntoView({ behavior: 'smooth' });
      }, 300);
    }
  </script> --}}
   @stack('scripts')
</body>
</html>
