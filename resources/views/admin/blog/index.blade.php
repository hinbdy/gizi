<x-layout title="Manajemen Artikel">
    <x-layouts.admin>
        <div class="bg-[#d6f6e4] min-h-screen py-10 px-4">
            <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-green-800">📰 Manajemen Artikel</h1>
                    <a href="{{ route('admin.blog.create') }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
                        + Tambah Artikel
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-left border-collapse">
                        <thead>
                            <tr class="bg-[#d6f6e4] text-green-900 uppercase text-sm font-semibold">
                                <th class="px-4 py-3">Judul</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Penulis</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Views</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                            @foreach ($articles as $article)
                                <tr class="hover:bg-green-50 transition">
                                    <td class="px-4 py-3 flex items-center gap-3">
                                        @if ($article->thumbnail)
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                 alt="thumb" class="w-12 h-12 object-cover rounded-md border">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 flex items-center justify-center text-xs rounded-md border">No Img</div>
                                        @endif
                                        <div class="font-medium">{{ $article->title }}</div>
                                    </td>

                                    {{-- INI BARIS YANG DIPERBAIKI --}}
                                    <td class="px-4 py-3">{{ $article->category->name ?? '-' }}</td>
                                    
                                    <td class="px-4 py-3">{{ $article->author->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if ($article->published)
                                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Published</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">Draft</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $article->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3">{{ $article->views }}</td>
                                    <td class="px-4 py-3 text-center space-x-2">
                                        <a href="{{ route('admin.blog.edit', $article) }}" class="text-orange-600 hover:text-orange-800" title="Edit">✏️</a>
                                        <form action="{{ route('admin.blog.destroy', $article) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($articles->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada artikel.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </x-layouts.admin>
</x-layout>