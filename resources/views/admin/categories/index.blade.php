<x-layouts.admin title="Manajemen Kategori Artikel">
    <div class="bg-white dark:bg-gizila-dark-card rounded-lg shadow-md p-6">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h2 class="text-2xl font-semibold text-gizila-dark dark:text-black">📚 Manajemen Kategori</h2>
            {{-- PERBARUI LINK TOMBOL --}}
            <a href="{{ route('admin.categories.create') }}" class="mt-4 md:mt-0 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">+ Tambah Kategori Baru</a>
        </div>

        {{-- Menampilkan notifikasi sukses --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-800 p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left border-collapse">
                <thead class="bg-[#d6f6e4] dark:bg-[#d6f6e4] text-gray-700 dark:text-black uppercase text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3">Nama Kategori</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Jumlah Artikel</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-black divide-y divide-[#d6f6e4] dark:divide-[#d6f6e4]">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-[#d6f6e4] dark:hover:bg-[#d6f6e4] transition">
                            <td class="px-4 py-3"><div class="font-medium">{{ $category->name }}</div></td>
                            <td class="px-4 py-3">{{ $category->slug }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.blog.index', ['category' => $category->slug]) }}" class="hover:underline">
                                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">
                                        {{ $category->articles_count }} Artikel
                                    </span>
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- PERBARUI LINK EDIT & HAPUS --}}
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-orange-600 hover:text-orange-800" title="Edit">✏️</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada kategori yang dibuat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $categories->links() }}</div>
    </div>
</x-layouts.admin>