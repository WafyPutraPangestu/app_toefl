<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-neutral-50 to-neutral-100 dark:from-neutral-900 dark:to-neutral-800">
        <div class="container mx-auto px-4 py-8 safe-top">
            <div class="max-w-screen-4xl mx-auto">
                <!-- Header Section -->
                <div class="card-mobile-lg mb-8 animate-fade-in">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </div>
                                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-neutral-50">Edit Teks Bacaan</h1>
                                </div>
                                <p class="text-neutral-600 dark:text-neutral-400 text-lg">
                                    Perbarui detail untuk teks '<span class="font-semibold text-primary-600 dark:text-primary-400">{{ $manajemen_reading->title }}</span>'
                                </p>
                            </div>
                            <a href="{{ route('manajemen-reading.index') }}" 
                               class="btn-mobile-lg bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-neutral-700 dark:text-neutral-300 tap-highlight-none group">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Kembali
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <form action="{{ route('manajemen-reading.update', $manajemen_reading) }}" method="POST" class="animate-slide-up">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-mobile-lg">
                        <div class="p-8">
                            <div class="space-y-8">
                                <!-- Paket Tes -->
                                <div class="space-y-2">
                                    <label for="test_package_id" class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            Paket Tes
                                            <span class="text-danger-500">*</span>
                                        </div>
                                    </label>
                                    <select name="test_package_id" id="test_package_id" required 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900 transition-all duration-200 -webkit-appearance-none">
                                        @foreach ($testPackages as $package)
                                            <option value="{{ $package->id }}" @selected(old('test_package_id', $manajemen_reading->test_package_id) == $package->id)>
                                                {{ $package->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('test_package_id')
                                        <div class="flex items-center gap-2 text-danger-600 dark:text-danger-400 text-sm mt-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Judul Teks -->
                                <div class="space-y-2">
                                    <label for="title" class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            Judul Teks
                                            <span class="text-danger-500">*</span>
                                        </div>
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           id="title"
                                           value="{{ old('title', $manajemen_reading->title) }}" 
                                           required
                                           placeholder="Masukkan judul teks bacaan..."
                                           class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 placeholder-neutral-500 dark:placeholder-neutral-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900 transition-all duration-200">
                                    @error('title')
                                        <div class="flex items-center gap-2 text-danger-600 dark:text-danger-400 text-sm mt-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Isi Teks Bacaan -->
                                <div class="space-y-2">
                                    <label for="passage_text" class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Isi Teks Bacaan (Passage)
                                            <span class="text-danger-500">*</span>
                                        </div>
                                    </label>
                                    <div class="relative">
                                        <textarea name="passage_text" 
                                                  id="passage_text" 
                                                  rows="15" 
                                                  required
                                                  placeholder="Masukkan isi teks bacaan di sini..."
                                                  class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 placeholder-neutral-500 dark:placeholder-neutral-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900 transition-all duration-200 resize-y reading-passage scroll-smooth">{{ old('passage_text', $manajemen_reading->passage_text) }}</textarea>
                                        <div class="absolute bottom-3 right-3 text-xs text-neutral-500 dark:text-neutral-400 bg-neutral-100 dark:bg-neutral-700 px-2 py-1 rounded-md">
                                            <span id="charCount">0</span> karakter
                                        </div>
                                    </div>
                                    @error('passage_text')
                                        <div class="flex items-center gap-2 text-danger-600 dark:text-danger-400 text-sm mt-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="px-8 py-6 bg-neutral-50 dark:bg-neutral-800/50 rounded-b-2xl border-t border-neutral-200 dark:border-neutral-700">
                            <div class="flex flex-col sm:flex-row gap-4 sm:justify-end">
                                <a href="{{ route('manajemen-reading.index') }}" 
                                   class="btn-mobile-lg bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-neutral-700 dark:text-neutral-300 tap-highlight-none text-center">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="btn-mobile-lg gradient-primary hover:shadow-lg text-white tap-highlight-none group relative overflow-hidden">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Update Teks
                                    </div>
                                    <div class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 ease-in-out"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Tips Section -->
                <div class="mt-8 card-mobile animate-fade-in" style="animation-delay: 0.2s;">
                    <div class="p-6">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-accent-100 dark:bg-accent-900 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-neutral-900 dark:text-neutral-100 mb-2">Tips untuk Teks Bacaan:</h3>
                                <ul class="text-sm text-neutral-600 dark:text-neutral-400 space-y-1">
                                    <li>• Pastikan teks mudah dipahami dan sesuai level TOEFL</li>
                                    <li>• Gunakan paragraf yang terstruktur dengan baik</li>
                                    <li>• Sertakan informasi yang cukup untuk membuat soal berkualitas</li>
                                    <li>• Hindari penggunaan kata atau frasa yang ambigu</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Character counter for passage text
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('passage_text');
            const charCount = document.getElementById('charCount');
            
            function updateCharCount() {
                charCount.textContent = textarea.value.length.toLocaleString();
            }
            
            textarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
            
            // Auto resize textarea
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });

        // Form validation enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                </div>
            `;
            submitButton.disabled = true;
        });
    </script>
</x-layout>