{{-- resources/views/components/admin/sidebar.blade.php --}}
@props(['title'])
<aside class="w-64 fixed top-0 left-0 h-full bg-white shadow-lg z-40">
    <div class="text-xl font-bold p-4 bg-green-100 text-green-700">Gizila Admin</div>
    <ul class="mt-4 space-y-1 px-4">
        <li><a href="{{ route('admin.dashboard') }}" class="block py-2 hover:bg-green-50 rounded">📊 Dashboard</a></li>
        <li><a href="{{ route('admin.blog.index') }}" class="block py-2 hover:bg-green-50 rounded">📝 Artikel</a></li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full text-left py-2 hover:bg-red-50 text-red-600 rounded">🚪 Logout</button>
            </form>
        </li>
    </ul>
</aside>
