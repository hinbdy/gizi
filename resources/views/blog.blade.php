<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="py-10">
        <h2 class="text-2xl font-semibold mb-6">Artikel Terbaru</h2>

        {{-- Misal contoh artikel dummy --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-[#1e1e1e] p-5 rounded-xl">
                <h3 class="text-lg font-bold mb-2">Judul Artikel 1</h3>
                <p class="text-sm text-belibang-grey">Ringkasan singkat artikel tentang gizi seimbang...</p>
            </div>
            <div class="bg-[#1e1e1e] p-5 rounded-xl">
                <h3 class="text-lg font-bold mb-2">Judul Artikel 2</h3>
                <p class="text-sm text-belibang-grey">Manfaat buah dan sayur bagi kesehatan tubuh...</p>
            </div>
            <div class="bg-[#1e1e1e] p-5 rounded-xl">
                <h3 class="text-lg font-bold mb-2">Judul Artikel 3</h3>
                <p class="text-sm text-belibang-grey">Tips menjaga pola makan sehat setiap hari...</p>
            </div>
        </div>
    </section>
</x-layout>
