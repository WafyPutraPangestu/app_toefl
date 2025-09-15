<x-layout>
    <div class="min-h-screen transition-colors duration-300" x-data="questionsCreate()">
        <!-- Hero Section dengan Gradient Modern -->
        <div class="relative overflow-hidden">
            <!-- Background Decorative Elements -->
            <div class="absolute bg-black inset-0">
                <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary-400/10 rounded-full blur-3xl"></div>
            </div>

            <!-- Grid Pattern Overlay -->
            <div class="absolute inset-0 opacity-20">
                <div class="h-full w-full"
                    style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 20px 20px;">
                </div>
            </div>

            <div class="relative px-4 py-20 sm:px-6 lg:px-8">
                <div class="text-center">
                    <!-- Icon dengan animasi -->
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-3xl mb-6 group">
                        <svg class="w-10 h-10 text-white dark:text-black group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>

                    <h1 class="text-5xl sm:text-6xl font-bold text-white dark:text-black mb-4 tracking-tight">
                        Buat Soal
                        <span class="bg-gradient-to-r from-accent-300 to-warning-300 bg-clip-text text-transparent">
                            TOEFL
                        </span>
                    </h1>

                    <p class="text-xl text-white/80 mb-8 font-medium">
                        Desain soal yang menarik dan menantang untuk peserta ujian
                    </p>

                    <!-- Breadcrumb Modern -->
                    <nav class="flex justify-center" aria-label="Breadcrumb">
                        <ol
                            class="inline-flex items-center space-x-1 md:space-x-3 bg-white/10 backdrop-blur-sm rounded-xl px-6 py-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('questions.index') }}"
                                    class="text-white/70 hover:text-white transition-colors duration-200">


                                    Bank Soal
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-white/50" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-white font-medium ml-1">Buat Soal</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-4 sm:px-6 lg:px-8 mt-10 relative z-10 pb-20">
            <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data"
                x-data="{ isSubmitting: false }">
                @csrf

                <!-- Main Card dengan Shadow Besar -->
                <div
                    class="bg-white dark:bg-neutral-800 rounded-3xl shadow-2xl border border-neutral-200 dark:border-neutral-700 overflow-hidden transition-all duration-300">

                    <!-- Progress Bar -->
                    <div class="h-2 bg-neutral-100 dark:bg-neutral-700">
                        <div class="h-full bg-gradient-to-r from-primary-500 to-secondary-500 rounded-r-full transition-all duration-500"
                            style="width: 0%" x-ref="progressBar"></div>
                    </div>

                    <div class="p-8 sm:p-12">

                        <!-- Section 1: Basic Information -->
                        <div class="mb-12">
                            <div class="flex items-center mb-8">
                                <div
                                    class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-2xl flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                                        Informasi Dasar
                                    </h2>
                                    <p class="text-neutral-600 dark:text-neutral-300 text-lg">
                                        Pilih kategori dan paket test untuk soal
                                    </p>
                                </div>
                            </div>

                            <!-- Cards Grid untuk Basic Info -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                                <!-- Test Package Card -->
                                <div
                                    class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800 group hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="w-8 h-8 bg-blue-500 rounded-xl flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <label class="text-sm font-semibold text-blue-900 dark:text-blue-100">
                                            Test Package
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                    </div>

                                    <select name="test_package_id" x-model="selectedTestPackageId" required
                                        class="w-full px-4 py-3 bg-white/80 dark:bg-neutral-800/80 backdrop-blur-sm border-0 rounded-xl text-neutral-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                                        <option value="">Pilih Test Package</option>
                                        @foreach ($testPackages as $package)
                                            <option value="{{ $package->id }}">{{ $package->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('test_package_id')
                                        <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Section Card -->
                                <div
                                    class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800 group hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="w-8 h-8 bg-purple-500 rounded-xl flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h4a2 2 0 002-2V9a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <label class="text-sm font-semibold text-purple-900 dark:text-purple-100">
                                            Section
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                    </div>

                                    <select name="section" x-model="selectedSection" required
                                        class="w-full px-4 py-3 bg-white/80 dark:bg-neutral-800/80 backdrop-blur-sm border-0 rounded-xl text-neutral-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all duration-200 shadow-sm">
                                        <option value="">Pilih Section</option>
                                        <option value="listening">🎧 Listening</option>
                                        <option value="structure">📝 Structure</option>
                                        <option value="reading">📖 Reading</option>
                                    </select>
                                    @error('section')
                                        <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Part Card -->
                                <div
                                    class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-2xl p-6 border border-emerald-200 dark:border-emerald-800 group hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                        </div>
                                        <label class="text-sm font-semibold text-emerald-900 dark:text-emerald-100">
                                            Part
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                    </div>

                                    <input type="text" name="part" value="{{ old('part') }}" required
                                        placeholder="A, B, Passage 1..."
                                        class="w-full px-4 py-3 bg-white/80 dark:bg-neutral-800/80 backdrop-blur-sm border-0 rounded-xl text-neutral-900 dark:text-white focus:ring-2 focus:ring-emerald-500 transition-all duration-200 shadow-sm placeholder-neutral-500 dark:placeholder-neutral-400">
                                    @error('part')
                                        <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Section Specific Content -->

                        <!-- Reading Section -->
                        <div x-show="selectedSection === 'reading'"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-8"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="mb-12">

                            <div
                                class="bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 rounded-3xl p-8 border border-amber-200 dark:border-amber-800">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-amber-900 dark:text-amber-100 mb-1">
                                            Reading Comprehension
                                        </h3>
                                        <p class="text-amber-700 dark:text-amber-200">
                                            Pilih passage yang akan digunakan untuk soal
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-amber-900 dark:text-amber-100 mb-4">
                                        Judul Teks Bacaan (Passage)
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select name="reading_passage_id" :disabled="!selectedTestPackageId"
                                        class="w-full px-6 py-4 bg-white/80 dark:bg-neutral-800/80 backdrop-blur-sm border-0 rounded-2xl text-neutral-900 dark:text-white focus:ring-2 focus:ring-amber-500 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                        <option value="">
                                            <span
                                                x-text="selectedTestPackageId ? 'Pilih Passage' : 'Pilih Test Package terlebih dahulu'"></span>
                                        </option>
                                        <template x-for="passage in filteredPassages" :key="passage.id">
                                            <option :value="passage.id" x-text="passage.title"></option>
                                        </template>
                                    </select>
                                    @error('reading_passage_id')
                                        <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Listening Section -->
                        <div x-show="selectedSection === 'listening'"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-8"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="mb-12">

                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-800/20 rounded-3xl p-8 border border-blue-200 dark:border-blue-800">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.798l-4.316-3.162A1 1 0 014 13v-2a1 1 0 01.067-.636l4.316-3.162zM16 7a3 3 0 000 6V7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-1">
                                            Audio File
                                        </h3>
                                        <p class="text-blue-700 dark:text-blue-200">
                                            Upload file audio untuk soal listening
                                        </p>
                                    </div>
                                </div>

                                <div class="relative">
                                    <div
                                        class="border-2 border-dashed border-blue-300 dark:border-blue-600 bg-blue-50/50 dark:bg-blue-900/10 rounded-2xl p-8 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300 group">
                                        <div
                                            class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-105 transition-transform duration-300">
                                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                            </svg>
                                        </div>

                                        <input type="file" name="audio_file" accept=".mp3,.wav,.ogg"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                                        <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">
                                            Drop file audio atau klik untuk browse
                                        </h4>
                                        <p class="text-sm text-blue-700 dark:text-blue-300 mb-4">
                                            Format yang didukung: MP3, WAV, OGG
                                        </p>
                                        <p class="text-xs text-blue-600 dark:text-blue-400">
                                            Maksimal ukuran file: 10MB
                                        </p>
                                    </div>
                                    @error('audio_file')
                                        <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Question Text -->
                        <div class="mb-12">
                            <div class="flex items-center mb-8">
                                <div
                                    class="w-12 h-12 bg-secondary-100 dark:bg-secondary-900/30 rounded-2xl flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-secondary-600 dark:text-secondary-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                                        Pertanyaan
                                    </h2>
                                    <p class="text-neutral-600 dark:text-neutral-300 text-lg">
                                        Tulis soal yang akan dijawab peserta
                                    </p>
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-br from-neutral-50 to-neutral-100 dark:from-neutral-800 dark:to-neutral-700 rounded-2xl p-8 border border-neutral-200 dark:border-neutral-600">
                                <label class="block text-sm font-semibold text-neutral-900 dark:text-white mb-4">
                                    Teks Soal
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea name="question_text" rows="6" required placeholder="Masukkan teks soal di sini..."
                                    class="w-full px-6 py-4 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-600 rounded-xl focus:ring-2 focus:ring-secondary-500 focus:border-transparent text-neutral-900 dark:text-white transition-all duration-200 resize-y placeholder-neutral-500 dark:placeholder-neutral-400">{{ old('question_text') }}</textarea>
                                @error('question_text')
                                    <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 4: Answer Choices -->
                        <div class="mb-12">
                            <div class="flex items-center mb-8">
                                <div
                                    class="w-12 h-12 bg-accent-100 dark:bg-accent-900/30 rounded-2xl flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-accent-600 dark:text-accent-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                                        Pilihan Jawaban
                                    </h2>
                                    <p class="text-neutral-600 dark:text-neutral-300 text-lg">
                                        Buat pilihan jawaban dan tentukan yang benar
                                    </p>
                                </div>
                            </div>

                            <!-- Answer Choices Grid -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @foreach (['A', 'B', 'C', 'D'] as $index => $choiceLetter)
                                    <div class="group">
                                        <div
                                            class="bg-white dark:bg-neutral-800 border-2 border-neutral-200 dark:border-neutral-700 rounded-2xl p-6 hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-lg transition-all duration-300 group-hover:bg-neutral-50 dark:group-hover:bg-neutral-750">

                                            <!-- Choice Header -->
                                            <div class="flex items-center space-x-4 mb-4">
                                                <!-- Radio Button -->
                                                <div class="relative">
                                                    <input type="radio" name="correct_answer"
                                                        value="{{ $choiceLetter }}" id="choice_{{ $choiceLetter }}"
                                                        {{ old('correct_answer') == $choiceLetter ? 'checked' : '' }}
                                                        class="w-5 h-5 text-primary-600 focus:ring-primary-500 border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 transition-all duration-200">
                                                    <!-- Custom Radio Design -->
                                                    <div
                                                        class="absolute inset-0 rounded-full border-2 border-transparent bg-gradient-to-r from-primary-500 to-secondary-500 opacity-0 group-hover:opacity-20 transition-opacity duration-200 pointer-events-none">
                                                    </div>
                                                </div>

                                                <!-- Choice Label -->
                                                <label for="choice_{{ $choiceLetter }}" class="cursor-pointer">
                                                    <div
                                                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-neutral-100 to-neutral-200 dark:from-neutral-700 dark:to-neutral-600 border-2 border-neutral-300 dark:border-neutral-500 flex items-center justify-center text-lg font-bold text-neutral-700 dark:text-neutral-200 group-hover:from-primary-100 dark:group-hover:from-primary-900/30 group-hover:to-primary-200 dark:group-hover:to-primary-800/30 group-hover:border-primary-400 dark:group-hover:border-primary-600 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-all duration-300">
                                                        {{ $choiceLetter }}
                                                    </div>
                                                </label>

                                                <!-- Choice Status Indicator -->
                                                <div class="flex-1 text-right">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-medium bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-300 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-all duration-200">
                                                        Pilihan {{ $choiceLetter }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Choice Input -->
                                            <div>
                                                <input type="text" name="choices[{{ $choiceLetter }}]"
                                                    value="{{ old('choices.' . $choiceLetter) }}"
                                                    placeholder="Masukkan teks pilihan {{ $choiceLetter }}"
                                                    class="w-full px-4 py-4 bg-neutral-50 dark:bg-neutral-750 border border-neutral-200 dark:border-neutral-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white transition-all duration-200 placeholder-neutral-500 dark:placeholder-neutral-400 group-hover:bg-white dark:group-hover:bg-neutral-800">

                                                @error('choices.' . $choiceLetter)
                                                    <p
                                                        class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @error('correct_answer')
                                <div
                                    class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                    <p class="text-red-700 dark:text-red-300 text-sm flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <strong class="font-medium">Pilih jawaban yang benar:</strong>&nbsp;
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror

                            <!-- Correct Answer Hint -->
                            <div
                                class="mt-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                                <div class="flex items-start">
                                    <div
                                        class="w-6 h-6 bg-amber-500 rounded-lg flex items-center justify-center mr-3 mt-0.5">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-200 mb-1">
                                            Tips Membuat Pilihan Jawaban
                                        </h4>
                                        <p class="text-sm text-amber-700 dark:text-amber-300">
                                            Pastikan jawaban yang salah tetap masuk akal agar soal lebih menantang.
                                            Pilih salah satu radio button untuk menandai jawaban yang benar.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t border-neutral-200 dark:border-neutral-700 pt-8">
                            <div
                                class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">

                                <!-- Left Side - Back Button -->
                                <a href="{{ route('questions.index') }}"
                                    class="inline-flex items-center px-6 py-3 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 rounded-xl hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-all duration-200 font-medium border border-neutral-300 dark:border-neutral-600 group">
                                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Kembali
                                </a>

                                <!-- Right Side - Save Button -->
                                <button type="submit" :disabled="isSubmitting" @click="isSubmitting = true"
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 text-white rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none group">

                                    <svg x-show="!isSubmitting"
                                        class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>

                                    <!-- Loading Spinner -->
                                    <svg x-show="isSubmitting" class="animate-spin w-5 h-5 mr-2" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>

                                    <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Soal'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function questionsCreate() {
            return {
                selectedSection: '{{ old('section', '') }}',
                selectedTestPackageId: '{{ old('test_package_id', '') }}',
                allPassages: @json($readingPassages),

                get filteredPassages() {
                    if (!this.selectedTestPackageId) {
                        return [];
                    }
                    return this.allPassages.filter(
                        p => p.test_package_id == this.selectedTestPackageId
                    );
                },

                init() {
                    // Update progress bar based on form completion
                    this.$watch('selectedSection', () => this.updateProgress());
                    this.$watch('selectedTestPackageId', () => this.updateProgress());

                    // Set initial progress
                    this.updateProgress();
                },

                updateProgress() {
                    let progress = 0;
                    if (this.selectedTestPackageId) progress += 33;
                    if (this.selectedSection) progress += 33;

                    // Check if question text has content
                    const questionText = document.querySelector('[name="question_text"]');
                    if (questionText && questionText.value.trim()) progress += 34;

                    this.$refs.progressBar.style.width = progress + '%';
                }
            }
        }

        // File upload preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const fileSize = (file.size / 1024 / 1024).toFixed(2);
                        const uploadArea = e.target.closest('.border-dashed');
                        const originalContent = uploadArea.innerHTML;

                        uploadArea.innerHTML = `
                            <div class="flex items-center justify-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-medium text-green-900 dark:text-green-100">${file.name}</p>
                                    <p class="text-sm text-green-700 dark:text-green-300">${fileSize} MB</p>
                                </div>
                            </div>
                        `;
                        uploadArea.classList.remove('border-dashed');
                        uploadArea.classList.add('border-solid', 'border-green-300',
                            'dark:border-green-600', 'bg-green-50', 'dark:bg-green-900/20');
                    }
                });
            }
        });
    </script>
</x-layout>
