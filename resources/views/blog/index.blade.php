<x-layouts.app :title="$title">
    {{-- <livewire:blog-index /> --}}
    <livewire:blog-index :category-slug="$category->slug ?? null" />
    <x-footer />
</x-layouts.app>