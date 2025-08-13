<div class="bg-gizila-radial py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
             <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
             <span class="relative inline-block">
                 Artikel Edukasi <span class="text-gizila-dark">Gizila</span>
                 <span class="absolute bottom-[-8px] left-0 h-1.5 w-full origin-left scale-x-0 transform bg-gizila-dark transition-transform duration-500 ease-in-out animate-draw-line"></span>
             </span>
         </h2>
            <p class="mt-2 text-lg leading-8 text-gray-600">
                Temukan informasi terbaru dari Gizila.
            </p>
        </div>

        {{-- 1. Tambahkan `items-stretch` agar semua kartu di baris yang sama memiliki tinggi yang seragam --}}
        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-10 lg:mx-0 lg:max-w-none lg:grid-cols-3 items-stretch">

            @forelse ($articles as $article)
                {{-- 2. Ganti `<article>` dengan `<div>` dan tambahkan class `group` --}}
                <div class="group relative">
                    <article class="flex h-full flex-col items-start justify-between rounded-2xl bg-[#d6f6e4] shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <div class="w-full">
                            {{-- 3. Tambahkan `overflow-hidden` pada pembungkus gambar untuk efek zoom yang rapi --}}
                            <div class="relative w-full overflow-hidden rounded-t-2xl">
                                <a href="{{ route('blog.show', $article) }}">
                                    {{-- 4. Tambahkan transisi dan efek `group-hover:scale-110` pada gambar --}}
                                    <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://via.placeholder.com/400x250.png/EBF5EE/344054?text=Gizila' }}" 
                                         alt="{{ $article->title }}" 
                                         class="aspect-[16/9] w-full bg-gray-100 object-cover transition-transform duration-500 ease-in-out group-hover:scale-110 sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <div class="absolute inset-0 rounded-t-2xl ring-1 ring-inset ring-gray-900/10"></div>
                                </a>
                            </div>

                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex-grow">
                                    <div class="flex items-center gap-x-4 text-xs mb-3">
                                        {{-- 5. Tambahkan ikon jam di sebelah tanggal --}}
                                        <div class="flex items-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <time datetime="{{ $article->created_at->toIso8601String() }}">
                                                {{ $article->created_at->format('d M Y') }}
                                            </time>
                                        </div>
                                        <a href="{{ route('category.show', $article->category->slug ?? 'umum') }}" class="relative z-10 rounded-full bg-green-50 px-3 py-1.5 font-medium text-green-700 hover:bg-green-100">
                                            {{ $article->category->name ?? 'Umum' }}
                                        </a>
                                    </div>

                                    {{-- 6. Perbaiki struktur dan class hover pada judul --}}
                                    <h3 class="mt-1 text-lg font-semibold leading-6">
                                        <a href="{{ route('blog.show', $article) }}">
                                            {{-- `span` ini penting untuk membuat seluruh kartu bisa diklik --}}
                                            <span class="absolute inset-0 z-0"></span> 
                                            <span class="relative text-gray-900 group-hover:text-green-700 transition-colors duration-300">{{ $article->title }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="relative mt-8 flex items-center gap-x-4 border-t border-gray-400 pt-4">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->name }}">
                                    <div class="text-sm leading-6">
                                        <p class="font-semibold text-gray-900">
                                            {{ $article->author->name ?? 'Admin' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada artikel yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16 text-center">
            <a href="{{ route('blog.index') }}" 
               class="px-6 py-3 bg-gizila-dark text-white font-semibold rounded-full hover:bg-green-800 transition-all duration-300 text-sm sm:text-base">
                Baca artikel edukasi lainnya
            </a>
        </div>

        
    </div>
</div>