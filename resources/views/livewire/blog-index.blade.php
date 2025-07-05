    <div class="bg-gizila-radial py-16 sm:py-24">
        {{-- DIUBAH: Menggunakan $persist untuk mengingat pilihan layout --}}
        <div x-data="{ layout: $persist('grid') }" class="mx-auto max-w-7xl px-6 lg:px-8">

            {{-- Judul Halaman --}}
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Artikel Edukasi Gizila</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">
                    Jelajahi wawasan gizi terbaru dari para ahli kami.
                </p>
            </div>

            {{-- TOOLBAR: Showing & Tombol Ganti Tampilan --}}
            <div class="mt-12 flex items-center justify-between rounded-lg bg-gizila-radial p-4 shadow-sm">
                <p class="text-sm text-gray-600">
                    Showing <span class="font-medium">{{ $articles->firstItem() }}</span> - <span class="font-medium">{{ $articles->lastItem() }}</span> of <span class="font-medium">{{ $articles->total() }}</span> results
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

            {{-- Container Utama Artikel --}}
            {{-- DITAMBAHKAN: INDIKATOR LOADING --}}
            <div wire:loading class="w-full text-center py-12">
                <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-green-600 motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                    <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
                </div>
                <p class="mt-3 text-sm text-gray-500">Memuat artikel...</p>
            </div>

            <div wire:loading.remove>
            <div class="mx-auto mt-8 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none" :class="{'lg:grid-cols-3': layout === 'grid', 'lg:grid-cols-1': layout === 'list'}">
                
                @forelse ($articles as $article)
                    {{-- KARTU ARTIKEL DENGAN DESAIN BARU --}}
                    <article class="bg-white rounded-2xl p-6 shadow-sm transition-all duration-300 ease-in-out hover:shadow-lg" 
                             :class="layout === 'list' ? 'flex flex-col md:flex-row gap-8 items-start' : 'flex flex-col'">
                        
                        {{-- Kolom Gambar (kiri saat mode list) --}}
                        <div class="relative w-full flex-shrink-0" :class="layout === 'list' ? 'md:w-1/3' : ''">
                            <a href="{{ route('blog.show', $article) }}">
                                <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://via.placeholder.com/400x250.png/EBF5EE/344054?text=Gizila' }}" 
                                     alt="{{ $article->title }}" class="aspect-[16/9] w-full rounded-xl bg-gray-100 object-cover">
                            </a>
                            {{-- Tag Views di atas gambar, hanya muncul di mode list --}}
                            <span x-show="layout === 'list'" class="absolute top-3 left-3 z-10 rounded-full bg-black/50 px-3 py-1.5 text-xs font-medium text-white">
                                {{ $article->views }} views
                            </span>
                        </div>

                        {{-- Kolom Konten Teks (kanan saat mode list) --}}
                        <div class="flex flex-col flex-grow h-full w-full" :class="layout === 'grid' ? 'mt-6' : ''">
                            <div class="flex-grow">
                                <div class="flex items-center gap-x-4 text-xs text-gray-500">
                                    <span>⭐</span>
                                    <time datetime="{{ $article->created_at->toIso8601String() }}">
                                        {{ $article->created_at->format('d M Y') }}
                                    </time>
                                </div>
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900">
                                    <a href="{{ route('blog.show', $article) }}">{{ $article->title }}</a>
                                </h3>
                            </div>
                            <div class="relative mt-6 flex w-full items-center justify-between text-sm text-gray-500 border-t border-gray-200 pt-4">
                                <div class="flex items-center gap-x-2">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->name }}">
                                    <span>{{ $article->author->name ?? 'Admin' }}</span>
                                </div>
                                <div class="flex items-center" x-show="layout === 'grid'">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                    <span>{{ $article->views }} views</span>
                                </div>
                                <a href="{{ route('blog.show', $article) }}" class="font-semibold text-green-600 hover:text-green-800">Read More &rarr;</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-1 lg:col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">Belum ada artikel yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

           {{-- Link Pagination --}}
            <div class="mt-16 flex justify-center">
                {{ $articles->links() }}
            </div>
            </div>
        </div>
    </div>
