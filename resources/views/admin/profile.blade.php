<x-layouts.admin title="Pengaturan Profil">
    {{-- Alpine.js untuk mengatur tab aktif, defaultnya 'profile' --}}
    <div x-data="{ activeTab: 'profile' }" class="space-y-6">

        {{-- ======================================================= --}}
        {{-- Tombol Navigasi Tab (DENGAN PERBAIKAN) --}}
        {{-- ======================================================= --}}
        <div class="border-b border-gray-200 dark:border-white/10">
            <nav class="-mb-px flex space-x-6">
                {{-- PERBAIKAN: Menambahkan data-tab-target="profile" --}}
                <button
                    data-tab-target="profile"
                    @click="activeTab = 'profile'"
                    :class="{ 'border-gizila-dark text-gizila-dark dark:border-white dark:text-white': activeTab === 'profile', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200': activeTab !== 'profile' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
                >
                    Profile
                </button>
                {{-- PERBAIKAN: Menambahkan data-tab-target="hakAkses" --}}
                <button
                    data-tab-target="hakAkses"
                    @click="activeTab = 'hakAkses'"
                    :class="{ 'border-gizila-dark text-gizila-dark dark:border-white dark:text-white': activeTab === 'hakAkses', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200': activeTab !== 'hakAkses' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
                >
                    Hak Akses
                </button>
            </nav>
        </div>

        {{-- Menampilkan Notifikasi Sukses atau Error --}}
        @if(session('success'))
            <div class="flex items-center bg-green-100 text-green-800 p-3 rounded-lg shadow-sm space-x-2 text-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center bg-red-100 text-red-800 p-3 rounded-lg shadow-sm space-x-2 text-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 13a1 1 0 112 0v-5a1 1 0 11-2 0v5zm1-8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- ======================================================= --}}
        {{-- Panel Konten untuk Tab "Profile"                       --}}
        {{-- ======================================================= --}}
        <div x-show="activeTab === 'profile'" x-cloak>
            <h2 class="text-xl font-bold text-gizila-dark dark:text-white">Profil Saya</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola avatar dan data profil kamu.</p>
            <div class="mt-6 bg-white dark:bg-gizila-dark-card p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center space-x-4">
                        @if ($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <label for="photo" class="cursor-pointer bg-gray-200 text-black font-semibold py-1 px-3 rounded-md text-sm hover:bg-gray-300">Ubah Foto</label>
                            <input type="file" name="photo" id="photo" accept="image/*" class="hidden">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-black ">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full border border-gray-300 rounded-lg p-2 bg-[#d6f6e4] dark:border-gray-600 dark:text-black">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-black">Ganti Password (opsional)</label>
                        <div x-data="{ show: false }" class="relative mt-1">
                            <input :type="show ? 'text' : 'password'" name="password" class="w-full border border-gray-300 rounded-lg p-2 pr-10 bg-[#d6f6e4] dark:border-gray-600" placeholder="Password Baru">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.06 10.06 0 0112 19c-4.5 0-8.36-2.92-9.82-7.06a10.38 10.38 0 012.94-4.38M6.07 6.07C7.64 4.91 9.68 4 12 4c4.5 0 8.36 2.92 9.82 7.06a10.38 10.38 0 01-1.26 2.36" /><line x1="2" y1="2" x2="22" y2="22" /><path d="M12 9a3 3 0 110 6 3 3 0 010-6z" /></svg>
                            </button>
                        </div>
                        <div x-data="{ show: false }" class="relative mt-2">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation" class="w-full border border-gray-300 rounded-lg p-2 pr-10 bg-[#d6f6e4] dark:border-gray-600" placeholder="Konfirmasi Password">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.06 10.06 0 0112 19c-4.5 0-8.36-2.92-9.82-7.06a10.38 10.38 0 012.94-4.38M6.07 6.07C7.64 4.91 9.68 4 12 4c4.5 0 8.36 2.92 9.82 7.06a10.38 10.38 0 01-1.26 2.36" /><line x1="2" y1="2" x2="22" y2="22" /><path d="M12 9a3 3 0 110 6 3 3 0 010-6z" /></svg>
                            </button>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded-lg shadow">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ======================================================= --}}
        {{-- Panel Konten untuk Tab "Hak Akses"                     --}}
        {{-- ======================================================= --}}
        <div x-show="activeTab === 'hakAkses'" x-cloak>
            <h2 class="text-xl font-bold text-gizila-dark dark:text-white">Manajemen Hak Akses</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tambah atau hapus admin yang dapat mengakses dashboard.</p>
            
            <div class="mt-6 bg-white dark:bg-gizila-dark-card p-6 rounded-lg shadow">
                <h3 class="font-semibold text-lg mb-4 text-gizila-dark dark:text-black">Tambah Admin Baru</h3>
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-black">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full border border-gray-300 rounded-lg p-2 bg-[#d6f6e4] dark:border-gray-600 dark:text-black">
                        @error('name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-black">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full border border-gray-300 rounded-lg p-2 bg-[#d6f6e4] dark:border-gray-600 dark:text-black">
                        @error('email')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-black">Password</label>
                        <div x-data="{ show: false }" class="relative mt-1">
                            <input :type="show ? 'text' : 'password'" name="password" required class="w-full border border-gray-300 rounded-lg p-2 pr-10 bg-[#d6f6e4] dark:border-gray-600">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.06 10.06 0 0112 19c-4.5 0-8.36-2.92-9.82-7.06a10.38 10.38 0 012.94-4.38M6.07 6.07C7.64 4.91 9.68 4 12 4c4.5 0 8.36 2.92 9.82 7.06a10.38 10.38 0 01-1.26 2.36" /><line x1="2" y1="2" x2="22" y2="22" /><path d="M12 9a3 3 0 110 6 3 3 0 010-6z" /></svg>
                            </button>
                        </div>
                        @error('password')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-black">Konfirmasi Password</label>
                        <div x-data="{ show: false }" class="relative mt-1">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation" required class="w-full border border-gray-300 rounded-lg p-2 pr-10 bg-[#d6f6e4] dark:border-gray-600">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.06 10.06 0 0112 19c-4.5 0-8.36-2.92-9.82-7.06a10.38 10.38 0 012.94-4.38M6.07 6.07C7.64 4.91 9.68 4 12 4c4.5 0 8.36 2.92 9.82 7.06a10.38 10.38 0 01-1.26 2.36" /><line x1="2" y1="2" x2="22" y2="22" /><path d="M12 9a3 3 0 110 6 3 3 0 010-6z" /></svg>
                            </button>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded-lg shadow">Daftarkan Admin</button>
                    </div>
                </form>
            </div>

            {{-- Daftar Admin yang Ada (Read & Delete) --}}
            <div class="mt-6 bg-white dark:bg-gizila-dark-card p-6 rounded-lg shadow">
                <h3 class="font-semibold text-lg mb-4 text-gizila-dark dark:text-black">Daftar Admin Gizila</h3>
                <div class="border-b border-gizila-dark dark:border-gray-700 my-4"></div>
                <div class="divide-y divide-gizila-dark dark:divide-gray-700">
                    @foreach($admins as $admin)
                        <div class="flex justify-between items-center py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $admin->photo ? asset('storage/' . $admin->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) . '&background=random&color=fff' }}" alt="Foto" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold text-gizila-dark dark:text-black">{{ $admin->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-500">{{ $admin->email }}</p>
                                </div>
                            </div>
                            <div>
                                @if(auth()->id() !== $admin->id)
                                <form method="POST" action="{{ route('admin.users.destroy', $admin) }}" onsubmit="return confirm('Anda yakin ingin menghapus admin ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-2 rounded-full">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- SCRIPT UNTUK MENGATUR TAB AKTIF (JANGAN DIHAPUS)      --}}
    {{-- ======================================================= --}}
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Cek jika ada session 'activeTab' yang dikirim dari Controller
            @if(session('activeTab'))
                // Ambil nama tab dari session
                let activeTabName = "{{ session('activeTab') }}";
                
                // Cari tombol yang punya atribut data-tab-target sesuai nama tab
                let tabTrigger = document.querySelector(`[data-tab-target="${activeTabName}"]`);
                
                // Jika tombol ditemukan, "klik" tombol itu untuk pindah tab
                if (tabTrigger) {
                    tabTrigger.click();
                }
            @endif
        });
    </script>
    @endpush
</x-layouts.admin>