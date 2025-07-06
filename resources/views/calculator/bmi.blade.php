@props(['title'])

<x-layout :title="$title">
  <section class="min-h-screen bg-gizila-radial py-24 px-4">
    <div class="max-w-4xl mx-auto bg-[#d6f6e4] rounded-xl shadow-xl p-8">
      <h1 class="text-3xl md:text-4xl font-bold text-center text-gizila-dark mb-6">
        Hitung Indeks Massa Tubuh (IMT)
      </h1>

      {{-- 1) FORM INPUT --}}
      <form method="POST" action="{{ route('bmi.calculate') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Berat Badan --}}
          <div>
            <label for="berat" class="font-semibold text-gray-700 block mb-2">Berat (kg)</label>
            <input
              type="number"
              name="berat"
              id="berat"
              value="{{ old('berat', $berat ?? '') }}"
              class="w-full px-4 py-2 rounded-lg bg-[#fef5ee]" required>
          </div>

          {{-- Tinggi Badan --}}
          <div>
            <label for="tinggi" class="font-semibold text-gray-700 block mb-2">Tinggi (cm)</label>
            <input
              type="number"
              name="tinggi"
              id="tinggi"
              value="{{ old('tinggi', $tinggi ?? '') }}"
              class="w-full px-4 py-2 rounded-lg bg-[#fef5ee]" required>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Usia --}}
          <div>
            <label for="usia" class="font-semibold text-gray-700 block mb-2">Usia (tahun)</label>
            <input
              type="number"
              name="usia"
              id="usia"
              value="{{ old('usia', $usia ?? '') }}"
              class="w-full px-4 py-2 rounded-lg bg-[#fef5ee]" required>
          </div>

          {{-- Jenis Kelamin --}}
          <div>
            <label class="font-semibold text-gray-700 block mb-2">Jenis Kelamin</label>
            <div class="flex gap-4">
              <label class="flex items-center gap-2">
                <input
                  type="radio"
                  name="jenis_kelamin"
                  value="male"
                  {{ old('jenis_kelamin', $jenisKelamin ?? '') == 'male' ? 'checked' : '' }}
                  required>
                Laki‐laki
              </label>
              <label class="flex items-center gap-2">
                <input
                  type="radio"
                  name="jenis_kelamin"
                  value="female"
                  {{ old('jenis_kelamin', $jenisKelamin ?? '') == 'female' ? 'checked' : '' }}
                  required>
                Perempuan
              </label>
            </div>
          </div>
        </div>

        {{-- Aktivitas --}}
        <div class="mt-4">
          <label class="font-semibold text-gray-700 block mb-2">Tingkat Aktivitas:</label>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
              // Deskripsi pendek untuk tiap opsi
              $levels = [
                'sangat-ringan'  => '*Sedikit atau tidak ada olahraga',
                'ringan' => '*Olahraga ringan 1–3x/minggu',
                'sedang'        => '*Olahraga sedang 3–5x/minggu',
                'berat' => '*Latihan fisik berat 6–7x/minggu',
              ];
            @endphp

            @foreach ($levels as $key => $deskripsi)
              <label class="cursor-pointer">
                <input
                  type="radio"
                  name="aktivitas"
                  value="{{ $key }}"
                  class="sr-only peer"
                  {{ old('aktivitas', $aktivitas ?? '') === $key ? 'checked' : '' }}
                  required>
                <div class="flex flex-col h-60 w-full bg-[#fef5ee] rounded-xl
                            border-4 peer-checked:border-green-700 shadow overflow-hidden">
                  {{-- Gambar opsi --}}
                  <div class="flex-1 bg-[#faf6eb] flex items-center justify-center">
                    <img
                      src="{{ asset('assets/images/aktivitas/' . $key . '.png') }}"
                      class="max-h-36 object-contain"
                      alt="{{ $key }}">
                  </div>
                  {{-- Deskripsi di bawah --}}
                  <div class="text-center px-2 py-4 bg-[#d6f6e4]">
                    <p class="text-[9px] text-gray-600 italic leading-tight">
                      {{ $deskripsi }}
                    </p>
                  </div>
                </div>
              </label>
            @endforeach
          </div>
        </div>
        <div class="text-center mt-6">
          <button type="submit"
            class="px-6 py-3 bg-green-700 text-white rounded-full font-semibold hover:bg-green-800 transition">
            Hitung IMT Kamu
          </button>
        </div>
      </form>
      {{-- 2) JIKA ADA session('bmi') → tampilkan hasil @isset($bmi) --}}
@isset($bmi)
<div id="hasil-bmi" class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
  {{-- Kotak 1: Berat + Kategori + BMR --}}
  <div class="bg-[#027527] text-white p-6 rounded-xl text-center flex flex-col items-center">
    <img src="{{ $bbImage }}" alt="{{ $kategoriBB }}" class="w-60 h-60 mx-auto rounded-full">
    <h2 class="text-xl font-semibold mb-2">Berat Badan Kamu</h2>
    <p class="text-2xl font-bold mb-2">{{ $kategoriBB }}</p>
    <p class="font-semibold text-sm mb-2">Total Energi yang Kamu Butuhkan:</p>
    <p class="text-3xl font-semibold text-yellow-300">{{ $bmr }} kkal</p>
    <p class="text-xs font-semibold mt-4">*Estimasi berdasarkan rumus Harris-Benedict</p>
  </div>

  {{-- Kotak 2: Hasil BMI --}}
  <div class="bg-[#027527] text-white p-6 rounded-xl text-center flex flex-col items-center">
    <img src="{{ $imtImage }}" alt="{{ $kategoriIMT }}" class="w-60 h-60 mx-auto rounded-full">
    <h2 class="text-xl font-semibold mb-2">Hasil IMT Kamu:</h2>
    <p class="text-3xl font-semibold text-yellow-300 mb-2">{{ $bmi }}</p>
    <p class="text-xs font-semibold">*Batas Normal IMT: 18.5 – 25.0</p>
  </div>

  {{-- Kotak 3: Berat Ideal dan Selisih --}}
  <div class="bg-[#027527] text-white p-6 rounded-xl text-center flex flex-col items-center">
    <img src="{{ $idealImage }}" alt="{{ $kategoriBeratIdeal }}" class="w-32 h-32 mb-4 rounded-full">
    <h2 class="text-lg font-semibold mb-2">Berat Badan Kamu Saat Ini:</h2>
    <p class="text-xl font-semibold text-yellow-300 mb-2">
      {{ $berat ?? '-' }}<span class="text-sm"> kg</span>
    </p>
    <p class="font-semibold mb-2">Kamu Sebaiknya Memiliki Berat Badan:</p>
    <p class="text-xl font-semibold text-yellow-300">
      {{ $beratIdeal ?? '-' }}<span class="text-sm"> kg</span>
    </p>
    <p class="text-xs font-semibold mt-2">
      *berdasarkan tinggi badan kamu: {{ $tinggi ?? '-' }} cm
    </p>
    <p class="mt-4 font-semibold {{ $selisihBerat > 0 ? 'text-yellow-300' : ($selisihBerat < 0 ? 'text-white-300' : 'text-yellow-300') }}">
      Kamu
      {{ $selisihBerat > 0 ? 'Kelebihan' : ($selisihBerat < 0 ? 'Kekurangan' : 'Sudah Ideal') }}
      Berat Badan:
    </p>
    <p class="text-xl font-semibold text-yellow-300">
      {{ abs($selisihBerat) }}<span class="text-sm"> kg</span>
    </p>
  </div>
</div>
@endisset

{{-- 3) Script JavaScript --}}
<script>
  // Fungsi untuk scroll otomatis ke hasil BMI
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form[action="{{ route('bmi.calculate') }}"]');
    const hasilBMI = document.getElementById('hasil-bmi');

    if (hasilBMI) {
      hasilBMI.scrollIntoView({ behavior: 'smooth' });
    }
  });
</script>
    </div>
  </section>
 {{-- Popup Notifikasi --}}
  <div id="popup" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-gizila-radial p-6 rounded-lg shadow-lg max-w-lg w-full text-center transition-all duration-300 transform scale-90 opacity-0">
    <h2 class="text-2xl font-semibold mb-4 text-green-700">Lanjut ke Kalkulator Gizi Harian?</h2>
    <p class="mb-6 text-green-700 font-semibold">Gunakan hasil BMI Anda untuk menghitung kebutuhan kalori harian.</p>
    <div class="flex justify-center gap-4">
      <a href="{{ url('/kalkulator-gizi-harian') }}"
         class="px-5 py-3 font-semibold rounded-lg border border-gizila-dark text-green-700 hover:bg-[#027527] hover:text-white transition">
        Lanjut Hitung Gizi Harian
      </a>
      <button onclick="closePopup()"
              class="px-5 py-3  font-semibold rounded-lg border border-gizila-dark text-green-700 hover:bg-[#027527] hover:text-white underline transition">
        Batal
      </button>
    </div>
  </div>
</div>

{{-- Script JavaScript --}}
<script>
  function openPopup() {
    const popup = document.getElementById('popup');
    const content = popup.querySelector('div');

    popup.classList.remove('hidden');
    setTimeout(() => {
      content.classList.remove('opacity-0', 'scale-90');
      content.classList.add('opacity-100', 'scale-100');
      popup.classList.add('flex');
    }, 50);
  }

  function closePopup() {
    const popup = document.getElementById('popup');
    const content = popup.querySelector('div');

    content.classList.remove('opacity-100', 'scale-100');
    content.classList.add('opacity-0', 'scale-90');
    setTimeout(() => {
      popup.classList.add('hidden');
    }, 300);
  }

  document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname;
    if (currentPath === "/kalkulator-massa-tubuh/hitung") {
      setTimeout(openPopup, 3000);
    }
  });
</script>
<x-footer />
</x-layout>
