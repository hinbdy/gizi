@props([
    'comment',
    'replyingTo' => null
])

<div class="bg-white p-5 rounded-xl shadow-md border border-gray-200" id="comment-{{ $comment->id }}">
    <div class="flex items-start gap-4">
        {{-- Avatar --}}
        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? $comment->guest_name) }}&background=a7f3d0&color=059669&font-size=0.33"
             alt="{{ $comment->user->name ?? $comment->guest_name }}"
             class="w-11 h-11 rounded-full flex-shrink-0">

        <div class="w-full">
            {{-- Nama & Waktu --}}
            <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                <p class="font-bold text-gray-800">{{ $comment->user->name ?? $comment->guest_name }}</p>
                <p class="text-xs text-gray-500 mt-1 sm:mt-0">{{ $comment->created_at->diffForHumans() }}</p>
            </div>

            {{-- Isi Komentar --}}
            <p class="text-gray-700 mt-2 break-words">
                {!! nl2br(e($comment->body)) !!}
            </p>
        </div>
    </div>

    {{-- Form Balasan --}}
    @if ($replyingTo === $comment->id)
        <div class="mt-4 ml-8 md:ml-14 pt-4 border-t">
            <form wire:submit.prevent="addReply">
                @guest
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" wire:model.defer="replyComment.guest_name" placeholder="Nama Anda*" 
                                   class="w-full text-sm border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50">
                            @error('replyComment.guest_name') 
                                <span class="text-red-500 text-xs">{{ $message }}</span> 
                            @enderror
                        </div>
                        <div>
                            <input type="email" wire:model.defer="replyComment.guest_email" placeholder="Email Anda*" 
                                   class="w-full text-sm border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50">
                            @error('replyComment.guest_email') 
                                <span class="text-red-500 text-xs">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                @endguest

                <textarea wire:model.defer="replyComment.body" rows="3" 
                          class="w-full text-sm border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50"
                          placeholder="Tulis balasan Anda..."></textarea>
                @error('replyComment.body') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror

                <div class="hidden">
                    <input type="text" wire:model="replyComment.honeypot">
                </div>

                <div class="flex items-center justify-end gap-x-4 mt-2">
                    <button wire:click.prevent="cancelReply" type="button" 
                            class="text-sm font-semibold text-gray-600 hover:underline">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-gizila-dark text-white font-semibold py-1.5 px-4 rounded-lg hover:bg-opacity-90 text-sm">
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
