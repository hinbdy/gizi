<x-layout :title="'Edit Artikel'">
    <x-layouts.admin >
        <div class="bg-white shadow-xl rounded-2xl p-8 max-w-5xl mx-auto mt-10 border border-green-200">
            <h2 class="text-3xl font-bold text-green-800 mb-8 flex items-center gap-2">
                ✏️ Edit Artikel
            </h2>

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

            <form action="{{ route('admin.blog.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Artikel</label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-400 focus:outline-none" required>
                    </div>

                    {{-- BAGIAN INI DIUBAH KEMBALI MENJADI INPUT TEKS --}}
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori (Ketik untuk membuat baru)</label>
                        <input type="text" name="category_name" value="{{ old('category_name', $article->category->name ?? '') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-400 focus:outline-none" required>
                    </div>
                    {{-- AKHIR BAGIAN YANG DIUBAH --}}

                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select name="published" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-400 focus:outline-none">
                            <option value="1" {{ old('published', $article->published) ? 'selected' : '' }}>Terpublikasi</option>
                            <option value="0" {{ !old('published', $article->published) ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail (opsional)</label>
                        <input type="file" name="thumbnail" accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 file:bg-green-600 file:text-white file:px-4 file:py-2 file:rounded-md hover:file:bg-green-700">
                        @if($article->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" class="h-32 object-cover rounded-md border">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konten Artikel</label>
                    <textarea name="content" rows="10"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-400 focus:outline-none"
                              required>{{ old('content', $article->content) }}</textarea>
                </div>

                <div class="text-right pt-4">
                    <a href="{{ route('admin.blog.index') }}"
                       class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg mr-2 transition">Batal</a>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </x-layouts.admin>
</x-layout>