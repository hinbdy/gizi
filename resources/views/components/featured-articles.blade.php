<div class="bg-gizila-radial py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Artikel Edukasi Gizila</h2>
            <p class="mt-2 text-lg leading-8 text-gray-600">
                Dapatkan Informasi Gizi Terbaru dan Terpercaya.
            </p>
        </div>

        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">

            @forelse ($articles as $article)
                <article class="flex flex-col items-start justify-between">
                    <a href="{{ route('blog.show', $article) }}" class="w-full">
                        <div class="relative w-full">
                            <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://via.placeholder.com/400x250.png/EBF5EE/344054?text=Gizila' }}" 
                                 alt="{{ $article->title }}" 
                                 class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                    </a>
                    <div class="w-full">
                        <div class="mt-8 flex items-center gap-x-4 text-xs">
                            <time datetime="{{ $article->created_at->toIso8601String() }}" class="text-gray-500">
                                {{ $article->created_at->format('d M Y') }}
                            </time>
                            <a href="#" class="relative z-10 rounded-full bg-green-50 px-3 py-1.5 font-medium text-green-700 hover:bg-green-100">
                                {{ $article->category->name ?? 'Umum' }}
                            </a>
                        </div>
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                <a href="{{ route('blog.show', $article) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $article->title }}
                                </a>
                            </h3>
                        </div>
                        <div class="relative mt-8 flex items-center gap-x-4">
                             <img class="h-10 w-10 rounded-full object-cover" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->name }}">
                            <div class="text-sm leading-6">
                                <p class="font-semibold text-gray-900">
                                    {{ $article->author->name ?? 'Admin' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada artikel yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16 text-center">
            <a href="{{ route('blog.index') }}" 
               class="inline-block rounded-md border border-gray-300 bg-gizila-dark px-6 py-3 text-white font-semibold text-white-700 shadow-sm hover:bg-green-800">
                Baca artikel edukasi lainnya
            </a>
        </div>

    </div>
</div>