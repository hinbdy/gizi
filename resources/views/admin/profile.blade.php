{{-- resources/views/admin/profile.blade.php --}}

@props(['title' => 'Admin'])
<x-layouts.admin title="Profil Admin">
    <div class="space-y-6">
        <h1 class="text-xl font-bold text-gray-800">Profil Saya</h1>

@if(session('success'))
    <div class="flex items-center bg-[#d6f6e4] text-dark p-3 rounded shadow-sm space-x-2">
        <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif


@if(session('error'))
    <div class="flex items-center bg-red-100 text-red-700 p-3 rounded shadow-sm space-x-2">
        <svg class="w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-8-3a1 1 0 00-1 1v3a1 1 0 002 0V8a1 1 0 00-1-1zm0 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
@endif


        {{-- @if(session('success'))
            <div class="bg-[#d6f6e4] text-green-700 p-3 rounded">{{ session('success') }}</div>
        @endif --}}
<div class="flex items-center space-x-4 mb-6">
    @if ($user->photo)
        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil"
             class="w-24 h-24 rounded-full object-cover border-2 border-white shadow-md">
    @else
        <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center text-white text-2xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
    @endif
    <div>
        <div class="font-bold text-xl text-gray-800">{{ $user->name }}</div>
        <div class="text-sm text-gray-500">Admin</div>
    </div>
</div>

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-600">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="mt-1 w-full border border-gray-300 rounded-lg p-2">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600">Ganti Password (opsional)</label>
                <input type="password" name="password" class="mt-1 w-full border border-gray-300 rounded-lg p-2" placeholder="Password Baru">
                <input type="password" name="password_confirmation" class="mt-1 w-full border border-gray-300 rounded-lg p-2" placeholder="Konfirmasi Password">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600">Ubah Foto Profil</label>
                <input type="file" name="photo" accept="image/*" class="mt-1 w-full">
      
            <div class="mt-4">
    <button type="submit"
        class="bg-green-700 hover:bg-green-900 text-white font-semibold py-2 px-4 rounded shadow">
        Simpan
    </button>
</div>

</x-layouts.admin>
