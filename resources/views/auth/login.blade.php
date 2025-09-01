<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 px-4 py-8">
        <div class="w-full max-w-screen-md">
            <!-- Notification -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-2"
                    class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-green-700 text-sm">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-green-400 hover:text-green-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-2"
                    class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-red-700 text-sm">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Login Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-gray-600">Masuk ke akun Anda</p>
                </div>

                <!-- Google Login -->
                <!-- Tombol Sign Up dengan Google -->
                <div class="mb-4">
                    <a href="{{ route('signup.google') }}"
                        class="w-full flex items-center justify-center px-4 py-3 border border-blue-300 rounded-xl shadow-sm bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors duration-200 font-medium">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M21.8 12.1h-9.2v3.4h5.3c-.2 1.4-1.6 4.1-5.3 4.1-3.2 0-5.8-2.7-5.8-6s2.6-6 5.8-6c1.8 0 3.1.8 3.7 1.4l2.6-2.5C17.2 3.8 15 3 12.6 3 7.5 3 3.5 7.1 3.5 12.1s4 9.1 9.1 9.1c5.3 0 8.8-3.7 8.8-8.9 0-.6-.1-1.1-.1-1.2z" />
                            <path fill="#34A853"
                                d="M12.6 21.2c3.3 0 6-1.1 8-3l-3.8-2.9c-1.1.7-2.4 1.1-4.2 1.1-3.2 0-5.9-2.2-6.9-5.1l-3.9 3c2 3.9 6.1 6.9 10.8 6.9z" />
                            <path fill="#FBBC05"
                                d="M5.7 14.3c-.3-.7-.4-1.5-.4-2.3s.1-1.6.4-2.3l-3.9-3c-.8 1.6-1.3 3.4-1.3 5.3s.5 3.7 1.3 5.3l3.9-3z" />
                            <path fill="#EA4335"
                                d="M12.6 7.7c1.8 0 3.1.8 3.8 1.4l2.8-2.8C17.5 4.7 15.2 3.5 12.6 3.5 7.9 3.5 3.8 6.5 1.8 10.4l3.9 3c1-2.9 3.7-5.1 6.9-5.1z" />
                        </svg>
                        Daftar dengan Google
                    </a>
                </div>

                <!-- Divider -->
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-gray-500 text-sm">atau</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Tombol Login dengan Google -->
                <div class="mb-6">
                    <a href="{{ route('login.google') }}"
                        class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M21.8 12.1h-9.2v3.4h5.3c-.2 1.4-1.6 4.1-5.3 4.1-3.2 0-5.8-2.7-5.8-6s2.6-6 5.8-6c1.8 0 3.1.8 3.7 1.4l2.6-2.5C17.2 3.8 15 3 12.6 3 7.5 3 3.5 7.1 3.5 12.1s4 9.1 9.1 9.1c5.3 0 8.8-3.7 8.8-8.9 0-.6-.1-1.1-.1-1.2z" />
                            <path fill="#34A853"
                                d="M12.6 21.2c3.3 0 6-1.1 8-3l-3.8-2.9c-1.1.7-2.4 1.1-4.2 1.1-3.2 0-5.9-2.2-6.9-5.1l-3.9 3c2 3.9 6.1 6.9 10.8 6.9z" />
                            <path fill="#FBBC05"
                                d="M5.7 14.3c-.3-.7-.4-1.5-.4-2.3s.1-1.6.4-2.3l-3.9-3c-.8 1.6-1.3 3.4-1.3 5.3s.5 3.7 1.3 5.3l3.9-3z" />
                            <path fill="#EA4335"
                                d="M12.6 7.7c1.8 0 3.1.8 3.8 1.4l2.8-2.8C17.5 4.7 15.2 3.5 12.6 3.5 7.9 3.5 3.8 6.5 1.8 10.4l3.9 3c1-2.9 3.7-5.1 6.9-5.1z" />
                        </svg>
                        Masuk dengan Google
                    </a>
                </div>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">atau</span>
                    </div>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.store') }}" x-data="{ loading: false }"
                    @submit="loading = true">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div x-data="{ show: false }" class="relative">
                                <input :type="show ? 'text' : 'password'" name="password" id="password" required
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('password') border-red-500 @enderror">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" :disabled="loading"
                            class="w-full bg-indigo-600 text-white font-semibold py-3 px-4 rounded-xl hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!loading">Masuk</span>
                            <span x-show="loading" class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
