{{-- resources/views/livewire/placeholders/article-list-skeleton.blade.php --}}
<div class="bg-gizila-radial py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Judul Halaman --}}
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Artikel Edukasi Gizila</h2>
            <p class="mt-2 text-lg leading-8 text-gray-600">
                Jelajahi wawasan gizi terbaru dari para ahli kami.
            </p>
        </div>

        {{-- Bar Pencarian --}}
        <div class="mt-12 mb-8 flex justify-center">
            <div class="relative w-full max-w-lg">
                <div class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-full shadow-sm bg-gray-200 animate-pulse h-[50px]"></div>
            </div>
        </div>

        {{-- Indikator Loading Utama --}}
        <div class="w-full text-center py-12">
            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-green-600 motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
            </div>
            <p class="mt-3 text-sm text-gray-500">Memuat artikel...</p>
        </div>
    </div>
</div>