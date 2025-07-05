{{-- resources/views/components/admin/topbar.blade.php --}}
@props(['title'])
<header class="ml-64 h-16 bg-white shadow px-6 flex items-center justify-between">
    <h1 class="text-xl font-semibold">{{ $title }}</h1>
    <div class="text-sm text-gray-500">👤 Admin</div>
</header>
