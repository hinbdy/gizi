<x-layout :title="$title">

    {{-- 1. Panggil komponen Livewire untuk bagian artikel yang dinamis --}}
    <livewire:blog-index />

    {{-- 2. Panggil komponen Footer di sini, di luar Livewire --}}
    <x-footer />

</x-layout>