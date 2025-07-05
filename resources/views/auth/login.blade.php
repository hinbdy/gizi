<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center bg-gizila-radial">
        <div class="bg-[#d6f6e4] p-8 rounded-xl shadow-md max-w-sm w-full">
            <h2 class="text-2xl font-bold text-center text-green-700 mb-6">Login Admin Gizila</h2>
            
            <!-- Error Notification -->
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    @foreach($errors->all() as $error)
                        <span class="block sm:inline">{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-green-700"
                        placeholder="Enter your email"
                        required
                    />
                </div>
                <!-- Password Field -->
                <div class="mb-6 relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-2 pr-10 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-green-700"
                            placeholder="Enter your password"
                            required
                        />
                        <button
                            type="button"
                            id="toggle-password"
                            class="absolute inset-y-0 right-3 flex items-center justify-center text-gray-500 focus:outline-none"
                            onclick="togglePassword()"
                        >
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" id="icon-eye-off" class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.06 10.06 0 0112 19c-4.5 0-8.36-2.92-9.82-7.06a10.38 10.38 0 012.94-4.38M6.07 6.07C7.64 4.91 9.68 4 12 4c4.5 0 8.36 2.92 9.82 7.06a10.38 10.38 0 01-1.26 2.36" />
                                <line x1="2" y1="2" x2="22" y2="22" />
                                <path d="M12 9a3 3 0 110 6 3 3 0 010-6z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full bg-green-700 hover:bg-green-900 text-white font-medium py-2 px-4 rounded-md shadow-md transition-all"
                    >
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('icon-eye');
            const eyeOffIcon = document.getElementById('icon-eye-off');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</x-layouts.app>
