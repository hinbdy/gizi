<section id="BlogSection" class="py-20 bg-gizila-radial">
    <div class="container max-w-[1130px] mx-auto px-4">
        <h2 class="font-bold text-2xl md:text-4xl text-gizila-dark mb-10 text-center">Artikel Gizila</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ([
                ['img' => 'img1.png', 'price' => 'Rp 129,000', 'title' => 'SaaS Website Master Template: Streamline Your Digital Solution', 'tag' => 'Template', 'logo' => 'framer.png', 'author' => 'Framer'],
                ['img' => 'img2.png', 'price' => 'Rp 700,000', 'title' => 'SaaS Website Master Template: Streamline Your Digital Solution', 'tag' => 'Template', 'logo' => 'framer.png', 'author' => 'Framer'],
                ['img' => 'img3.png', 'price' => 'Rp 89,000', 'title' => 'SaaS Website Essentials Your Blueprint to Success Online', 'tag' => 'Template', 'logo' => 'framer.png', 'author' => 'Framer'],
                ['img' => 'img4.png', 'price' => 'Rp 250,000', 'title' => 'Vitalize - Healthcare App UI Kit', 'tag' => 'Ebook', 'logo' => 'vekotora.svg', 'author' => 'Vektora Studio'],
                ['img' => 'img5.png', 'price' => 'Rp 88,000', 'title' => 'WYR™ - Fintech Design System', 'tag' => 'Course', 'logo' => 'strangehelix.svg', 'author' => 'strangehelix.bio'],
            ] as $product)
            <div class="bg-white rounded-xl shadow-lg flex flex-col">
                <a href="#" class="relative block h-48 rounded-t-xl overflow-hidden">
                    <img src="{{ asset('assets/images/thumbnails/' . $product['img']) }}" alt="{{ $product['title'] }}" class="w-full h-full object-cover">
                    <span class="absolute top-3 right-3 bg-black/60 text-white text-sm px-2 py-1 rounded">{{ $product['price'] }}</span>
                </a>
                <div class="p-4 flex flex-col justify-between h-full">
                    <div class="mb-3">
                        <a href="#" class="text-base font-semibold text-gray-900 hover:text-gray-700 line-clamp-2">{{ $product['title'] }}</a>
                        <p class="inline-block mt-2 text-xs font-medium text-white bg-gray-800 rounded px-2 py-1">{{ $product['tag'] }}</p>
                    </div>
                    <div class="flex items-center gap-2 mt-auto">
                        <div class="w-8 h-8 rounded-full overflow-hidden">
                            <img src="{{ asset('assets/images/logos/' . $product['logo']) }}" class="w-full h-full object-cover" alt="{{ $product['author'] }}">
                        </div>
                        <span class="text-sm text-gray-600">{{ $product['author'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
