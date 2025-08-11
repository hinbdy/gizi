<div 
    class="mt-16" 
    x-data="{ showComments: true }" 
    x-on:comment-added.window="document.getElementById('mainCommentForm').reset()">
<div class="mt-16" x-data="{ showComments: true }">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-gray-800 border-l-4 border-gizila-dark pl-4">
            Diskusi & Tanggapan
        </h2>
        <button 
            @click="showComments = !showComments" 
            class="bg-gizila-dark text-white font-semibold px-4 py-2 rounded-lg hover:bg-opacity-90 transition">
            <span x-show="!showComments">Tampilkan Diskusi</span>
            <span x-show="showComments">Sembunyikan Diskusi</span>
        </button>
    </div>

    {{-- Konten --}}
    <div x-show="showComments" x-transition>
        {{-- Form Komentar Utama --}}
        <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-gray-200">
            <form wire:submit.prevent="addMainComment" id="mainCommentForm">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('message') }}
                    </div>
                @endif
                @auth
                    <p class="text-sm text-gray-600 mb-2">Anda berkomentar sebagai: <span class="font-bold">{{ auth()->user()->name }}</span></p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" wire:model.defer="mainComment.guest_name" placeholder="Nama Anda*" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50">
                            @error('mainComment.guest_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="email" wire:model.defer="mainComment.guest_email" placeholder="Email Anda*" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50">
                            @error('mainComment.guest_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endauth
                <textarea wire:model.defer="mainComment.body" rows="4" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50" placeholder="Tulis tanggapan Anda di sini..."></textarea>
                @error('mainComment.body') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                <div class="hidden"><input type="text" wire:model="mainComment.honeypot"></div>
                <div class="text-right mt-4">
                    <button type="submit" class="bg-gizila-dark text-white font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">Kirim Tanggapan</button>
                </div>
            </form>
        </div>

        {{-- Daftar Komentar --}}
        <div class="space-y-8">
            @forelse ($comments as $comment)
                <div wire:key="comment-{{ $comment->id }}" class="bg-white p-4 sm:p-6 rounded-xl shadow-lg border border-gray-200">
                    
                    {{-- Tampilkan Komentar Utama --}}
                    <x-comment-card :comment="$comment" />

                    {{-- Tombol Aksi untuk Komentar Utama --}}
                    <div class="flex items-center space-x-4 mt-3 ml-auto pl-[52px]"> {{-- 52px = 44px avatar + 8px gap --}}
                        <button wire:click.prevent="startReply({{ $comment->id }})" class="text-sm font-semibold text-gizila-dark hover:underline">Balas</button>
                        <button wire:click.prevent="deleteComment({{ $comment->id }})" class="text-sm font-semibold text-red-600 hover:underline">Hapus</button>
                    </div>

                    {{-- Form Balasan (jika ada) --}}
                    @if ($replyingTo === $comment->id)
                        <div class="mt-4 ml-[52px] pt-4 border-t">
                            <form wire:submit.prevent="addReply">
                                @guest
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <input type="text" wire:model.defer="replyComment.guest_name" placeholder="Nama Anda*" class="w-full text-sm border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50">
                                            @error('replyComment.guest_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <input type="email" wire:model.defer="replyComment.guest_email" placeholder="Email Anda*" class="w-full text-sm border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50">
                                            @error('replyComment.guest_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endguest
                                <textarea wire:model.defer="replyComment.body" rows="3" class="w-full text-sm border-gray-300 rounded-md shadow-sm px-3 py-2 focus:border-gizila-dark focus:ring-gizila-dark/50" placeholder="Tulis balasan Anda..."></textarea>
                                @error('replyComment.body') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                <div class="hidden"><input type="text" wire:model="replyComment.honeypot"></div>
                                <div class="flex items-center justify-end gap-x-4 mt-2">
                                    <button wire:click.prevent="cancelReply" type="button" class="text-sm font-semibold text-gray-600 hover:underline">Batal</button>
                                    <button type="submit" class="bg-gizila-dark text-white font-semibold py-1.5 px-4 rounded-lg hover:bg-opacity-90 text-sm">Kirim Balasan</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    {{-- Daftar Balasan (jika ada) --}}
                    @if ($comment->replies->count() > 0)
                        <div class="mt-6 ml-8 md:ml-14 pl-4 border-l-2 border-gray-200 space-y-6">
                            @foreach ($comment->replies as $reply)
                                <div wire:key="reply-{{ $reply->id }}">
                                    {{-- Tampilkan Balasan --}}
                                    <x-comment-card :comment="$reply" />
                                    
                                    {{-- Tombol Aksi untuk Balasan --}}
                                    <div class="flex items-center space-x-4 mt-3 ml-auto pl-[52px]">
                                        <button wire:click.prevent="deleteComment({{ $reply->id }})" class="text-sm font-semibold text-red-600 hover:underline">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center text-gray-500 bg-white border-2 border-dashed p-8 rounded-lg">
                    <p>Belum ada tanggapan. Jadilah yang pertama berkomentar!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
</div>