<x-layouts.admin>
    <div class="bg-white dark:bg-gizila-dark-card rounded-lg shadow-md p-6">
        
        {{-- Header: Judul, Search, dan Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gizila-dark dark:text-black">📰 Manajemen Artikel</h1>
            </div>
            <div class="flex items-center gap-4 w-full sm:w-auto">
               {{-- Form Pencarian Admin --}}
<form action="{{ route('admin.blog.index') }}" method="GET" class="relative w-full sm:w-80">
    <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}"
        placeholder="Cari artikel... lalu klik enter" 
        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-gizila-dark bg-white dark:bg-white dark:border-gray-600 dark:text-black">
    {{-- Tombol Kirim (ikon search klik-able di kanan) --}}
    <button type="submit" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gizila-dark transition">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
    </button>
</form>

                <a href="{{ route('admin.blog.create') }}" class="flex-shrink-0 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                    + Tambah Artikel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left border-collapse">
                <thead>
                    <tr class="bg-[#d6f6e4] dark:bg-[#d6f6e4] text-gray-700 dark:text-black uppercase text-sm font-semibold">
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Penulis</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Views</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-black divide-y divide-[#d6f6e4] dark:divide-[#d6f6e4]">
                    @forelse ($articles as $article)
                        <tr class="hover:bg-[#d6f6e4] dark:hover:bg-[#d6f6e4] transition">
                           {{-- ... Isi tabel Anda tidak berubah ... --}}
                            <td class="px-4 py-3 flex items-center gap-3">
                                @if ($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="thumb" class="w-16 h-10 object-cover rounded-md border dark:border-gray-700">
                                @else
                                    <div class="w-16 h-10 bg-[#d6f6e4] dark:bg-[#d6f6e4] flex items-center justify-center text-xs rounded-md border dark:border-gray-600">No Img</div>
                                @endif
                                <div class="font-medium">{{ $article->title }}</div>
                            </td>
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
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.blog.edit', $article) }}" class="text-orange-600 hover:text-orange-800" title="Edit">✏️</a>
                                    <form action="{{ route('admin.blog.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                @if(request('search'))
                                    Artikel dengan judul "{{ request('search') }}" tidak ditemukan.
                                @else
                                    Belum ada artikel.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- TAMPILAN PAGINATION DITAMBAHKAN DI SINI --}}
        @if ($articles->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $articles->links('vendor.pagination.tailwind') }}
                </div>
            @endif
    </div>
</x-layouts.admin>