<x-layout :title="$article->title">
    <div class="bg-gizila-radial py-12">
        <div class="container mx-auto max-w-7xl px-4 lg:px-8 mt-16">
            
            {{-- Breadcrumbs --}}
            <nav class="text-sm mb-6" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center">
                    <li class="flex items-center">
                        <a href="/" class="text-gray-500 hover:text-gray-700">Home</a>
                        <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-gray-700">Blog</a>
                        <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li class="text-gray-400" aria-current="page">
                        {{ Str::limit($article->title, 25) }}
                    </li>
                </ol>
            </nav>

            {{-- Layout Utama: Konten Kiri, Sidebar Kanan --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-8 gap-y-12">
                
                {{-- KOLOM KONTEN UTAMA (KIRI) --}}
                <div class="lg:col-span-2">

                    {{-- Header Artikel yang Sudah Dirapikan --}}
                    <div class="mb-8">
                        {{-- Pastikan kategori ada sebelum membuat link --}}
                        @if($article->category)
                            <a href="{{ route('category.show', $article->category) }}" class="inline-block bg-green-100 text-green-800 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider hover:bg-green-200 transition">
                                {{ $article->category->name }}
                            </a>
                        @else
                            {{-- Tampilan jika artikel tidak punya kategori --}}
                            <span class="inline-block bg-gray-100 text-gray-800 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider">
                                Umum
                            </span>
                        @endif
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-3 mb-5 tracking-tight leading-tight">
                            {{ $article->title }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
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

                    {{-- Gambar Utama --}}
                    @if ($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="my-8 w-full rounded-2xl shadow-lg">
                    @endif

                    {{-- Isi Konten --}}
                    <article class="prose prose-lg max-w-none prose-green prose-img:rounded-xl">
                        {!! $article->content !!}
                    </article>

                    {{-- Share & Artikel Terkait (DIKEMBALIKAN) --}}
                    <div class="mt-12 border-t pt-8">
                        {{-- Tombol Share --}}
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

                        {{-- Artikel Terkait --}}
                        @if ($relatedArticles->count())
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-4">Artikel Terkait</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    @foreach ($relatedArticles as $related)
                                        <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">
                                            <a href="{{ route('blog.show', $related) }}">
                                                <img src="{{ $related->thumbnail ? asset('storage/' . $related->thumbnail) : 'https://via.placeholder.com/400x250.png/EBF5EE/344054?text=Gizila' }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                                            </a>
                                            <div class="p-4">
                                                <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded">{{ $related->category->name ?? 'Umum' }}</span>
                                                <a href="{{ route('blog.show', $related) }}" class="block mt-2 font-semibold text-gray-800 line-clamp-2 hover:text-green-700">{{ $related->title }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- KOLOM SIDEBAR (KANAN) --}}
                <aside class="lg:col-span-1 space-y-10 lg:sticky lg:top-24 self-start">
                    {{-- Widget Artikel Populer --}}
                    <div class="rounded-2xl bg-gray-50 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Artikel Populer</h3>
                        <ul class="space-y-6">
                            @forelse($popularArticles as $popular)
                                <li class="flex items-start gap-x-4">
                                    <a href="{{ route('blog.show', $popular) }}" class="w-20 h-20 flex-shrink-0">
                                        <img src="{{ $popular->thumbnail ? asset('storage/' . $popular->thumbnail) : 'https://via.placeholder.com/150x150.png/EBF5EE/344054?text=G' }}" alt="{{ $popular->title }}" class="w-20 h-20 rounded-lg object-cover">
                                    </a>
                                    <div>
                                        <h4 class="text-base font-semibold leading-tight text-gray-800 hover:text-green-700">
                                            <a href="{{ route('blog.show', $popular) }}">{{ $popular->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $popular->created_at->format('d M Y') }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-sm text-gray-500">Belum ada artikel populer.</li>
                            @endforelse
                        </ul>
                    </div>
                    
                    {{-- Widget Kategori --}}
                    <div class="rounded-2xl bg-gray-50 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Kategori</h3>
                        <ul class="space-y-3">
                            @forelse($categories as $category)
                                <li>
                                    <a href="{{ route('category.show', $category) }}" class="flex justify-between items-center text-gray-600 hover:text-green-700 font-medium">
                                        <span>{{ $category->name }}</span>
                                        <span class="text-xs bg-gray-200 text-gray-600 rounded-full px-2 py-0.5">{{ $category->articles_count }}</span>
                                    </a>
                                </li>
                            @empty
                                <li class="text-sm text-gray-500">Belum ada kategori.</li>
                            @endforelse
                        </ul>
                    </div>
                </aside>
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-16 text-center">
                <a href="{{ route('blog.index') }}" class="inline-block text-green-600 hover:text-green-800 text-sm font-medium">
                    ← Kembali ke daftar artikel
                </a>
            </div>
        </div>
    </div>
</x-layout>
<x-footer />