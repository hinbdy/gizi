<div class="bg-gizila-radial py-16 sm:py-24">
    <div x-data="{ layout: $persist('grid') }" class="mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Judul Halaman (Tidak diubah) --}}
        <div class="mx-auto max-w-2xl text-center">
             <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
             <span class="relative inline-block">
                Artikel Edukasi <span class="text-gizila-dark">Gizila</span>
            <span class="absolute bottom-[-8px] left-0 h-1.5 w-full origin-left scale-x-0 transform bg-gizila-dark transition-transform duration-500 ease-in-out animate-draw-line"></span>
             </span>
            </h2>

            <p class="mt-2 text-lg leading-8 text-gray-600">
                Jelajahi artikel Gizila sekarang!
            </p>
        </div>

        {{-- Bar Pencarian (Tidak diubah) --}}
        <div class="mt-12 mb-8 flex justify-center">
             {{-- ... (kode search bar Anda) ... --}}
        </div>

        {{-- Toolbar (Tidak diubah) --}}
        <div class="mt-12 flex items-center justify-between rounded-lg bg-[#d6f6e4] p-4 shadow-sm">
            <p class="text-sm text-gray-600">
                Menampilkan <span class="font-medium">{{ $articles->firstItem() ?? 0 }}</span> - <span class="font-medium">{{ $articles->lastItem() ?? 0 }}</span> dari <span class="font-medium">{{ $articles->total() }}</span> hasil artikel gizila
            </p>
            <div class="flex items-center gap-x-2">
                <button @click="layout = 'grid'" :class="{ 'bg-gray-200 text-gray-800': layout === 'grid', 'text-gray-500 hover:bg-gray-100': layout !== 'grid' }" class="p-2 rounded-md transition" title="Grid View">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                </button>
                <button @click="layout = 'list'" :class="{ 'bg-gray-200 text-gray-800': layout === 'list', 'text-gray-500 hover:bg-gray-100': layout !== 'list' }" class="p-2 rounded-md transition" title="List View">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                </button>
            </div>
        </div>

        {{-- Indikator Loading (Tidak diubah) --}}
        <div wire:loading.delay.long class="w-full text-center py-12">
            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-green-600 motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
            </div>
            <p class="mt-3 text-sm text-gray-500">Memuat artikel...</p>
        </div>

        {{-- Grid Artikel --}}
        <div wire:loading.remove>
            {{-- PERUBAHAN 1: Tambahkan `items-stretch` pada div grid utama --}}
            <div class="mx-auto mt-8 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none items-stretch" :class="{'lg:grid-cols-3': layout === 'grid', 'lg:grid-cols-1': layout === 'list'}">
                
                @forelse ($articles as $article)
                    {{-- 1. Bungkus kartu dengan `div class="group"` untuk mengaktifkan efek hover turunan --}}
                    <div class="group"> 
                        {{-- 2. Tambahkan efek `hover:-translate-y-2` (efek timbul) pada <article> --}}
                        <article wire:key="article-{{ $article->id }}" class="bg-[#d6f6e4] rounded-2xl shadow-md transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-2 h-full flex flex-col overflow-hidden" 
                                 :class="layout === 'list' ? 'md:flex-row gap-8 items-start' : ''">
                            
                            {{-- Kolom Gambar --}}
                            <div class="relative w-full flex-shrink-0" :class="layout === 'list' ? 'md:w-1/3' : ''">
                                <a href="{{ route('blog.show', $article) }}">
                                    {{-- 3. Tambahkan `transition` dan `group-hover:scale-110` untuk efek zoom pada gambar --}}
                                    <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://via.placeholder.com/400x250.png/EBF5EE/344054?text=Gizila' }}" 
                                         alt="{{ $article->title }}" class="aspect-[16/9] w-full bg-gray-100 object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                                </a>
                                <span x-show="layout === 'list'" class="absolute top-3 left-3 z-10 rounded-full bg-black/50 px-3 py-1.5 text-xs font-medium text-white">
                                    {{ $article->views }} views
                                </span>
                            </div>

                            {{-- Kolom Konten Teks --}}
                            <div class="flex flex-col flex-grow p-6" :class="layout === 'grid' ? 'mt-0' : 'mt-6'">
                                <div class="flex-grow">
                                    {{-- ... (kode tanggal dan ikon jam) ... --}}
                                    <h3 class="mt-3 text-lg font-semibold leading-6">
                                        {{-- 4. Pastikan class `group-hover` ada di sini untuk judul --}}
                                        <a href="{{ route('blog.show', $article) }}" class="text-gray-900 group-hover:text-green-700 transition-colors duration-300">
                                            {{ $article->title }}
                                        </a>
                                    </h3>
                                </div>
     
                                {{-- Area bawah kartu (penulis, views) --}}
                                <div class="relative mt-6 flex w-full items-center justify-between text-sm text-gray-500 border-t border-gray-400 pt-4">
                                    <div class="flex items-center gap-x-2">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->name }}">
                                        <span>{{ $article->author->name ?? 'Admin' }}</span>
                                    </div>
                                    <div class="flex items-center" x-show="layout === 'grid'">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                        <span>{{ $article->views }} views</span>
                                    </div>
                                    <a href="{{ route('blog.show', $article) }}" class="font-semibold text-black-600 hover:text-green-800">Read More &rarr;</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-span-1 lg:col-span-3 text-center py-12">
                        @if (empty($search))
                            <p class="text-gray-500 text-lg">Belum ada artikel yang dipublikasikan.</p>
                        @else
                            <p class="text-gray-500 text-lg">Artikel dengan judul "<span class="font-semibold">{{ $search }}</span>" tidak ditemukan.</p>
                        @endif
                    </div>
                @endforelse
            </div>

            @if ($articles->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $articles->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>