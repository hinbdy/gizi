<x-layouts.admin title="Edit Kategori">
     <div class="bg-white dark:bg-gizila-dark-card rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gizila-dark dark:text-black mb-6">✏️ Edit Kategori</h2>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-black mb-1">Nama Kategori</label>
                <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black bg-[#d6f6e4] dark:border-gray-600 dark:text-black" required>
                 @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>
            <div class="text-right">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold transition">Batal</a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg font-semibold transition">Perbarui</button>
            </div>
        </form>
    </div>
</x-layouts.admin>