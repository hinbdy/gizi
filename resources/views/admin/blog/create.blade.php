@props(['title' => ''])

<x-layout :title="'Tambah Artikel Baru'">
    <x-layouts.admin :title="$title">
        <div class="bg-white shadow-xl rounded-2xl p-8 max-w-5xl mx-auto mt-10 border border-green-200">
            <h2 class="text-3xl font-bold text-green-800 mb-8 flex items-center gap-2">
                📝 Tambah Artikel Baru
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

            <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Artikel</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                    </div>

                    {{-- BAGIAN INI DIUBAH KEMBALI MENJADI INPUT TEKS --}}
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori (Ketik untuk membuat baru)</label>
                        <input type="text" name="category_name" value="{{ old('category_name') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                    </div>
                    {{-- AKHIR BAGIAN YANG DIUBAH --}}

                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select name="published" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="1" {{ old('published', '1') == '1' ? 'selected' : '' }}>Terpublikasi</option>
                            <option value="0" {{ old('published') == '0' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail (opsional)</label>
                        <input type="file" name="thumbnail" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2 file:mr-3 file:border-0 file:bg-green-600 file:text-white file:px-4 file:py-2 file:rounded-md hover:file:bg-green-700">
                    </div>
                </div>

                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konten Artikel</label>
                    <textarea name="content" rows="10" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>{{ old('content') }}</textarea>
                </div>

                <div class="text-right pt-4">
                    <a href="{{ route('admin.blog.index') }}"
                        class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg mr-2 transition">Batal</a>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </x-layouts.admin>
</x-layout>