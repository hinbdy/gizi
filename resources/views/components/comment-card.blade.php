@props(['comment'])

<div class="flex items-start gap-4">
    {{-- Avatar --}}
    <img 
        src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? $comment->guest_name) }}&background=a7f3d0&color=059669&font-size=0.33"
        alt="{{ $comment->user->name ?? $comment->guest_name }}"
        class="w-11 h-11 rounded-full flex-shrink-0"
    >

    <div class="w-full">
        {{-- Nama & Waktu --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center">
            <p class="font-bold text-gray-800">
                {{ $comment->user->name ?? $comment->guest_name }}
            </p>
            <p class="text-xs text-gray-500 mt-1 sm:mt-0">
                {{ $comment->created_at->diffForHumans() }}
            </p>
        </div>

        {{-- Isi Komentar --}}
        <p class="text-gray-700 mt-2 break-words">
            {!! nl2br(e($comment->body)) !!}
        </p>
    </div>
</div>