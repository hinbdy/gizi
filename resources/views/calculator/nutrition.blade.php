<x-layout :title="'Kalkulator Gizi Harian'">
  <section class="min-h-screen bg-gizila-radial py-24 px-4">
    <div class="max-w-5xl mx-auto bg-[#d6f6e4] rounded-xl shadow-xl p-8">
      <h1 class="text-3xl md:text-4xl font-bold text-center text-gizila-dark mb-6">
        Kalkulator Gizi Harian Anda
      </h1>

      @if(session('bmr'))
        <div class="bg-white p-6 rounded-lg shadow mb-6 text-center">
          <p class="text-lg font-medium text-gray-700">Kebutuhan Kalori Harian Anda (berdasarkan BMI):</p>
          <p class="text-3xl font-bold text-green-700 mt-2">{{ session('bmr') }} kkal</p>
        </div>

        <div class="text-center mb-12">
          <button onclick="tampilkanFormGizi()"
            class="px-6 py-3 bg-green-700 text-white rounded-full font-semibold hover:bg-green-800 transition">
            Hitung Gizi Harian Kamu
          </button>
        </div>
      @else
        <script>
          alert("Silakan isi Kalkulator Massa Tubuh terlebih dahulu.");
          window.location.href = "{{ url('/kalkulator-massa-tubuh') }}";
        </script>
      @endif

      <div id="form-gizi-harian" class="hidden opacity-0 scale-95 transition-all duration-700">
        <form method="POST" action="{{ url('/kalkulator-gizi-harian/hitung') }}" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @php $sesi = ['Sarapan', 'Makan Siang', 'Makan Malam']; @endphp

          @foreach($sesi as $key => $label)
          <div class="grid md:grid-cols-2 gap-6 bg-white p-6 rounded-xl shadow-md mb-8 items-start">
            {{-- Kolom Kiri --}}
            <div>
              <h3 class="text-xl font-bold mb-4 text-gizila-dark">{{ $label }}</h3>
              <div class="space-y-4" id="menu-{{ $key }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end menu-row min-w-0">
                  <div class="w-full">
                    <label class="block mb-1 font-medium">Pilih Makanan</label>
                    <select name="foods[{{ $key }}][]" class="makanan-select w-full text-sm px-3 py-2 rounded-md">
                      <option value="">-- Pilih --</option>
                      @foreach($foods->sortBy('name')->unique('name') as $food)
                        <option value="{{ $food->id }}" data-kalori="{{ $food->kalori }}">{{ $food->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="w-full">
                    <label class="block mb-1 font-medium">Berat (gram)</label>
                    <input type="number" name="weights[{{ $key }}][]" min="0" value="0"
                           class="berat-input w-full border-gray-300 rounded-md shadow-sm" />
                  </div>

                  <div class="w-full">
                    <label class="block mb-1 font-medium">Kalori</label>
                    <input type="text" readonly class="kalori-output w-full bg-gray-100 border-gray-300 rounded-md shadow-sm" />
                  </div>
                </div>
              </div>
              <button type="button" onclick="tambahBaris('{{ $key }}')" class="mt-4 text-sm text-green-700 hover:underline">
                + Tambah Menu Lainnya
              </button>
            </div>

            {{-- Kolom Kanan: Upload & Kamera --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full justify-center md:justify-start">
              <div class="flex flex-col items-center gap-2 w-full">
                <label for="uploadInput-{{ $key }}" class="w-[180px] min-h-[180px] bg-white rounded-lg border-2 border-dashed border-green-500 flex flex-col items-center justify-center text-center cursor-pointer relative overflow-hidden"
                       ondragover="event.preventDefault();"
                       ondrop="handleDrop(event, '{{ $key }}')">
                  <img id="imagePreview-{{ $key }}" src="" alt="Preview"
                       class="absolute inset-0 w-full h-full object-cover hidden rounded-lg" />
                  <div id="uploadPlaceholder-{{ $key }}" class="z-10 flex flex-col items-center justify-center pointer-events-none text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mb-2" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v16h16V4H4zm8 12l-4-4h3V8h2v4h3l-4 4z" />
                    </svg>
                    <p><span class="font-semibold">Upload</span> / drag file</p>
                  </div>
                  <input id="uploadInput-{{ $key }}" type="file" name="images[{{ $key }}]"
                         accept="image/*" capture="environment"
                         class="absolute inset-0 opacity-0 cursor-pointer z-20"
                         onchange="previewImage(this, '{{ $key }}')" />
                </label>
                <p class="text-xs text-gray-400 text-center">Format: <span class="text-green-600 font-medium">.jpg, .jpeg, .png</span></p>
              </div>

              <div class="flex flex-col items-center gap-2 w-full">
                <label for="cameraInput-{{ $key }}" class="w-[180px] min-h-[180px] bg-white rounded-lg border-2 border-dashed border-green-500 flex flex-col items-center justify-center text-center cursor-pointer relative overflow-hidden">
                  <img id="cameraPreview-{{ $key }}" src="" alt="Camera Preview"
                       class="absolute inset-0 w-full h-full object-cover hidden rounded-lg" />
                  <div id="cameraPlaceholder-{{ $key }}" class="z-10 flex flex-col items-center justify-center pointer-events-none text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mb-2" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h4l1-2h8l1 2h4v12H3V7z" />
                    </svg>
                    <p><span class="font-semibold">Ambil Foto</span> dari kamera</p>
                  </div>
                  <input id="cameraInput-{{ $key }}" type="file" name="camera_images[{{ $key }}]"
                         accept="image/*"
                         class="absolute inset-0 opacity-0 cursor-pointer z-20"
                         onchange="previewCamera(this, '{{ $key }}')" />
                </label>
                <p class="text-xs text-gray-400 text-center">Kamera: <span class="text-green-600 font-medium">langsung ambil gambar</span></p>
              </div>
            </div>
          </div>
          @endforeach

          <div class="text-center">
            <button type="submit"
              class="px-6 py-3 bg-green-700 text-white rounded-full font-semibold hover:bg-green-800 transition">
              Hitung Total Kalori Konsumsi Hari Ini
            </button>
          </div>
        </form>
      </div>

      @isset($kalori)
        <div class="mt-12 bg-green-700 text-white p-8 rounded-xl shadow-lg">
          <h2 class="text-2xl font-bold mb-4 text-center">Total Kalori dari Makanan</h2>
          <p class="text-4xl font-bold text-yellow-300 text-center mb-4">{{ $kalori }} kkal</p>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-green-800 p-4 rounded-lg shadow-md text-center">
              <p class="font-medium text-gray-200">Karbohidrat</p>
              <p class="text-3xl font-bold text-yellow-300">{{ $karbohidratGram }} g</p>
            </div>
            <div class="bg-green-800 p-4 rounded-lg shadow-md text-center">
              <p class="font-medium text-gray-200">Protein</p>
              <p class="text-3xl font-bold text-yellow-300">{{ $proteinGram }} g</p>
            </div>
            <div class="bg-green-800 p-4 rounded-lg shadow-md text-center">
              <p class="font-medium text-gray-200">Lemak</p>
              <p class="text-3xl font-bold text-yellow-300">{{ $lemakGram }} g</p>
            </div>
          </div>
        </div>
      @endisset
    </div>
  </section>

  {{-- SCRIPT --}}
  <script>
    function tampilkanFormGizi() {
      const form = document.getElementById('form-gizi-harian');
      form.classList.remove('hidden');
      setTimeout(() => {
        form.classList.remove('opacity-0', 'scale-95');
        form.classList.add('opacity-100', 'scale-100');
        $('.makanan-select').select2({ placeholder: "-- Pilih Makanan --", allowClear: true, width: '100%' });
      }, 10);
      setTimeout(() => {
        window.scrollBy({ top: 300, behavior: 'smooth' });
      }, 300);
    }

    function tambahBaris(sesi) {
      const container = document.getElementById('menu-' + sesi);
      const originalRow = container.querySelector('.menu-row');
      const row = originalRow.cloneNode(true);

      row.querySelectorAll('select, input').forEach(el => {
        if (el.type === 'select-one') el.selectedIndex = 0;
        if (el.type === 'number') el.value = 0;
        if (el.classList.contains('kalori-output')) el.value = '';
      });

      if (!row.querySelector('.hapus-menu-btn')) {
        const col = document.createElement('div');
        col.className = 'col-span-full text-right';
        col.innerHTML = `
          <button type="button" class="hapus-menu-btn text-red-600 text-sm font-medium hover:underline"
                  onclick="hapusFormMenu(this)">Hapus</button>`;
        row.appendChild(col);
      }

      container.appendChild(row);
      $(row).find('.makanan-select').select2({ placeholder: "-- Pilih Makanan --", allowClear: true, width: '100%' });
    }

    function hapusFormMenu(button) {
      const row = button.closest('.menu-row');
      row.remove();
    }

    document.addEventListener('input', function (e) {
      if (e.target.classList.contains('berat-input') || e.target.classList.contains('makanan-select')) {
        const row = e.target.closest('.menu-row');
        const select = row.querySelector('.makanan-select');
        const berat = parseFloat(row.querySelector('.berat-input').value) || 0;
        const kaloriPer100g = parseFloat(select.options[select.selectedIndex]?.dataset.kalori || 0);
        const kalori = (kaloriPer100g / 100) * berat;
        row.querySelector('.kalori-output').value = kalori.toFixed(1) + ' kkal';
      }
    });

    function previewImage(input, key) {
      const preview = document.getElementById(`imagePreview-${key}`);
      const placeholder = document.getElementById(`uploadPlaceholder-${key}`);
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
          placeholder?.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    function previewCamera(input, key) {
      const preview = document.getElementById(`cameraPreview-${key}`);
      const placeholder = document.getElementById(`cameraPlaceholder-${key}`);
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
          placeholder?.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    function handleDrop(e, key) {
      e.preventDefault();
      const input = document.getElementById(`uploadInput-${key}`);
      input.files = e.dataTransfer.files;
      previewImage(input, key);
    }

    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('input[type="file"][name^="camera_images"]').forEach(input => {
        if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
          input.setAttribute('capture', 'environment');
        }
      });

      $('.makanan-select').select2({
        placeholder: "-- Pilih Makanan --",
        allowClear: true,
        width: '100%'
      });
    });
  </script>

  <x-footer />
</x-layout>
