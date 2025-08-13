<x-layout :title="$article->title">
    <div class="bg-gizila-radial py-12">
        <div class="container mx-auto max-w-7xl px-4 lg:px-8 mt-16">
            
            {{-- Breadcrumbs (Navigasi Halaman, tidak diubah) --}}
            <nav class="text-sm mb-6" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center text-gray-600">
                    <li class="flex items-center">
                        <a href="/" class="hover:text-green-700">Home</a>
                        <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('blog.index') }}" class="hover:text-green-700">Blog</a>
                        <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li class="text-gray-400" aria-current="page">
                        {{ Str::limit($article->title, 30) }}
                    </li>
                </ol>
            </nav>

            {{-- --- MULAI STRUKTUR BARU 2 KOLOM --- --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-12 gap-y-12">
                
                {{-- --- KOLOM KONTEN UTAMA (KIRI) --- --}}
                <div class="lg:col-span-2">

                    {{-- Header Artikel --}}
                    <div class="mb-6">
                        @if($article->category)
                            <a href="{{ route('category.show', $article->category) }}" class="inline-block bg-green-100 text-green-800 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider hover:bg-green-200 transition">
                                {{ $article->category->name }}
                            </a>
                        @endif
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-3 mb-5 tracking-tight leading-tight">
                            {{ $article->title }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500 border-t border-b py-4">
                            <div class="flex items-center gap-x-3">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->name }}">
                                <span class="font-semibold text-gray-800">{{ $article->author->name ?? 'Admin' }}</span>
                            </div>
                            <span class="hidden sm:inline text-gray-300">&bull;</span>
                            <time datetime="{{ $article->created_at->toIso8601String() }}">{{ $article->created_at->format('d F Y') }}</time>
                            <span class="hidden sm:inline text-gray-300">&bull;</span>
                            <div class="flex items-center gap-x-1.5">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                <span>{{ $article->views }} views</span>
                            </div>
                        </div>
                    </div>

                    {{-- Gambar Utama Artikel --}}
                    @if ($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="my-8 w-full rounded-2xl shadow-lg">
                    @endif

                    {{-- Isi Konten Artikel --}}
                    <article class="prose prose-lg max-w-none prose-green prose-img:rounded-xl">
                        {{-- Diubah untuk keamanan dan menjaga format paragraf --}}
                        {!! nl2br(e($article->content)) !!}
                    </article>

                    {{-- Tombol Share (Kode Anda, tidak diubah) --}}
                    <div class="mt-12 border-t pt-8">
                        <div class="mb-12"> 
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bagikan artikel ini:</h3>
                            <div class="flex items-center gap-x-5">
                                @php
                                    $shareUrl = urlencode(url()->current());
                                    $shareText = urlencode($article->title);
                                @endphp
                                <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" title="Bagikan ke WhatsApp"><i class="fab fa-whatsapp text-2xl text-gray-800 hover:text-green-600 transition"></i></a>
                                <a href="https://t.me/share/url?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" title="Bagikan ke Telegram"><i class="fab fa-telegram text-2xl text-gray-800 hover:text-blue-500 transition"></i></a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" title="Bagikan ke Facebook"><i class="fab fa-facebook text-2xl text-gray-800 hover:text-blue-800 transition"></i></a>
                                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" title="Bagikan ke X"><i class="fab fa-x-twitter text-2xl text-gray-800 hover:text-black transition"></i></a>
                                <a href="https://www.instagram.com/akun-gizila-anda/" target="_blank" title="Lihat di Instagram"><i class="fab fa-instagram text-2xl text-gray-800 hover:text-pink-600 transition"></i></a>
                            </div>
                        </div>
                    </div>

        {{-- Ganti blok "Artikel Terkait" Anda dengan kode di bawah ini --}}
                @if ($relatedArticles->count())
                <div>
                    <div class="mt-12 border-t pt-8">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Artikel terkait:</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach ($relatedArticles as $related)
                                {{-- 1. Tambahkan `group` untuk mengaktifkan efek hover pada elemen turunan --}}
                                <div class="group bg-[#d6f6e4] rounded-xl shadow transition-all duration-300 ease-in-out hover:shadow-lg hover:-translate-y-1">
                                    {{-- 2. Tambahkan `overflow-hidden` agar efek zoom gambar tidak keluar dari kotak --}}
                                    <div class="overflow-hidden rounded-t-xl">
                                        <a href="{{ route('blog.show', $related->slug) }}">
                                            {{-- 3. Tambahkan class transisi & `group-hover:scale-110` untuk efek zoom --}}
                                            <img src="{{ $related->thumbnail ? asset('storage/' . $related->thumbnail) : 'https://via.placeholder.com/400x250.png/EBF5EE/344054?text=Gizila' }}"
                                                alt="{{ $related->title }}"
                                                class="w-full h-40 object-cover transition-transform duration-500 group-hover:scale-110">
                                        </a>
                                    </div>
                                    <div class="p-4">
                                        {{-- 4. Ubah `span` kategori menjadi `a` (link) --}}
                                        <a href="{{ route('category.show', $related->category->slug ?? 'umum') }}" class="text-xs bg-green-50 text-green-800 px-2 py-1 rounded-full font-semibold hover:bg-green-100 transition-colors">
                                            {{ $related->category->name ?? 'Umum' }}
                                        </a>
                                        <a href="{{ route('blog.show', $related->slug) }}"
                                        class="block mt-2 font-semibold text-gray-800 line-clamp-2 group-hover:text-green-700 transition-colors">
                                            {{ $related->title }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif          

                    @livewire('article-comments', ['article' => $article])

                </div>
                
                {{-- --- KOLOM SIDEBAR (KANAN) --- --}}
                <aside class="lg:col-span-1 space-y-10 lg:sticky lg:top-24 self-start">
                    
                    {{-- Widget Pencarian --}}
                    <div class="rounded-2xl bg-[#d6f6e4] p-6 shadow-sm border">
                        <form action="{{ route('blog.index') }}" method="GET">
                            <label for="search-sidebar" class="font-semibold text-gray-700 mb-2 block">Cari Judul Artikel</label>
                            <div class="relative">
                                <input type="text" id="search-sidebar" name="search" placeholder="Ketik di sini..." class="w-full rounded-md px-3 py-2 bg-gray-100 border-gray-300 pr-10 focus:ring-green-500 focus:border-green-500">
                                <button type="submit" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-green-700">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Widget Artikel Terbaru --}}
                    <div class="rounded-2xl bg-[#d6f6e4] p-6 shadow-sm border">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Artikel Terbaru</h3>
                        <ul class="space-y-5">
                            @forelse($latestArticles as $latest)
                                <li class="flex items-start gap-x-4">
                                    <a href="{{ route('blog.show', $latest) }}" class="w-20 h-20 flex-shrink-0">
                                        <img src="{{ $latest->thumbnail ? asset('storage/' . $latest->thumbnail) : 'https://via.placeholder.com/150' }}" alt="{{ $latest->title }}" class="w-20 h-20 rounded-lg object-cover">
                                    </a>
                                    <div>
                                        <h4 class="text-base font-semibold leading-tight text-gray-800 hover:text-green-700">
                                            <a href="{{ route('blog.show', $latest) }}">{{ $latest->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $latest->created_at->format('d M Y') }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-sm text-gray-500">Belum ada artikel lain.</li>
                            @endforelse
                        </ul>
                    </div>
                    
                    {{-- Widget Kategori (Kode Anda, dipindahkan ke sini) --}}
                    <div class="rounded-2xl bg-[#d6f6e4] p-6 shadow-sm border">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Kategori</h3>
                        <ul class="space-y-3">
                            @forelse($categories as $category)
                                @if($category->articles_count > 0)
                                    <li>
                                        <a href="{{ route('category.show', $category) }}" class="flex justify-between items-center text-gray-600 hover:text-green-700 font-medium">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-xs bg-gray-200 text-gray-600 rounded-full px-2 py-0.5">{{ $category->articles_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @empty
                                <li class="text-sm text-gray-500">Belum ada kategori.</li>
                            @endforelse
                        </ul>
                    </div>
                </aside>
            </div>
            
        </div>
    </div>
    <x-footer />
</x-layout>