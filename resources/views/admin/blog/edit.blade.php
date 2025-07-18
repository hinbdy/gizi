<x-layouts.admin title="Tambah Artikel Baru">
    {{-- Container utama, sudah full-width --}}
    <div class="bg-white dark:bg-gizila-dark-card rounded-lg shadow-md p-6">
        
        <h2 class="text-2xl font-semibold text-gizila-dark dark:text-black mb-6">
            ✏️ Edit Artikel
        </h2>

        {{-- Menampilkan jika ada error validasi --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-800 p-4 rounded-lg">
                <strong>Ada kesalahan dalam form:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

       {{-- PERUBAHAN DI SINI: form action menuju ke route 'update' dan method 'PUT' --}}
        <form action="{{ route('admin.blog.update', $article->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Grid untuk input bagian atas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-black mb-1">Judul Artikel</label>
                    <input id="title" type="text" name="title" value="{{ old('title', $article->title) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black bg-[#d6f6e4] dark:border-gray-600 dark:text-black" required>
                </div>

                <div>
                    <label for="category_name" class="block text-sm font-semibold text-gray-700 dark:text-black mb-1">Kategori</label>
                    {{-- PERUBAHAN DI SINI: Tampilkan value dari $article->category->name --}}
                    <input id="category_name" type="text" name="category_name" value="{{ old('category_name', $article->category->name) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black bg-[#d6f6e4] dark:border-gray-600 dark:text-black" placeholder="Ketik untuk membuat baru" required>
                </div>
                
               <div>
    <label for="published" class="block text-sm font-semibold text-gray-700 dark:text-black mb-1">Status</label>
    {{-- Komponen Dropdown Kustom dengan Alpine.js --}}
    <div 
        x-data="{ 
            open: false, 
            options: [
                { value: '1', text: 'Terpublikasi' },
                { value: '0', text: 'Draft' }
            ],
            selected: { value: '1', text: 'Terpublikasi' }
        }" 
        {{-- PERUBAHAN DI SINI: x-init diubah untuk mengambil data dari $article->published --}}
        x-init="selected = options.find(opt => opt.value == '{{ old('published', $article->published) }}') || options[0]"
        class="relative">
        <input type="hidden" name="published" :value="selected.value">
        <button 
            type="button" 
            @click="open = !open" 
            class="w-full border border-gray-300 rounded-md px-3 py-2 flex justify-between items-center text-left bg-[#d6f6e4] dark:border-gray-600 dark:text-black"
        >
            <span x-text="selected.text"></span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>

        <div 
            x-show="open" 
            @click.away="open = false" 
            x-transition 
            class="absolute z-10 mt-1 w-full rounded-md shadow-lg border border-gray-300 bg-[#d6f6e4]" 
            style="display: none;"
        >
            <template x-for="option in options" :key="option.value">
                <div 
                    @click="selected = option; open = false;"
                    {{-- PERUBAHAN DI SINI: Mengubah gaya untuk item yang aktif --}}
                    class="px-4 py-2 cursor-pointer text-black hover:bg-gizila-dark hover:text-white"
                    :class="{ 'font-semibold text-gizila-dark': selected.value === option.value }"
                >
                    <span x-text="option.text"></span>
                </div>
            </template>
        </div>
    </div>
</div>
                <div>
                    <label for="thumbnail" class="block text-sm font-semibold text-gray-700 dark:text-black mb-1">Thumbnail (opsional)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm font-semibold text-gray-500 file:mr-3 file:border-0 file:bg-[#d6f6e4] file:text-gray-700 dark:file:bg-[#d6f6e4] dark:file:text-black file:px-4 file:py-2 file:rounded-md hover:file:bg-gray-300 dark:hover:file:bg-gray-200">
                    @if($article->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" class="h-16 object-cover rounded-md border">
                            </div>
                        @endif
                </div>
            </div>

            {{-- Input untuk Konten Artikel --}}
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-black mb-1">Konten Artikel</label>
                {{-- PERUBAHAN DI SINI: Tampilkan value dari $article->content --}}
                <textarea id="content" name="content" rows="10" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black bg-[#d6f6e4] dark:border-gray-600 dark:text-black" required>{{ old('content', $article->content) }}</textarea>
            </div>

            {{-- Tombol Aksi --}}
            <div class="text-right pt-4">
                <a href="{{ route('admin.blog.index') }}" class="inline-block font-semibold bg-[#d6f6e4] hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg mr-2 transition dark:bg-[#d6f6e4] dark:text-black dark:hover:bg-gray-200">Batal</a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>