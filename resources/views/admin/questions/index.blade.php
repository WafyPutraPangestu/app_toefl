<x-layout>
    <div class=" dark:bg-background-dark" x-data="questionsIndex()">
        <div class="bg-gradient-primary relative overflow-hidden">
            <div class="absolute inset-0 bg-background-secondary-dark"></div>
            <div class="absolute inset-0 opacity-20"></div>
            <div class="relative px-4 py-12 sm:px-6 lg:px-8">
                <div class="max-w-screen-7xl mx-auto">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                            Bank Soal TOEFL
                        </h1>
                        <p class="text-xl text-white/90 max-w-screen-2xl mx-auto">
                            Kelola dan atur koleksi soal TOEFL untuk berbagai test package dengan mudah
                        </p>
                        <div class="mt-8 flex flex-wrap justify-center gap-3">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2">
                                <span class="text-white/90 text-sm">Total Soal: </span>
                                <span class="text-white font-bold">{{ $questions->total() }}</span>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2">
                                <span class="text-white/90 text-sm">Package: </span>
                                <span class="text-white font-bold">{{ $testPackages->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-screen-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 relative z-10">
            <div class="mb-8">
                <div class="card-mobile-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-black dark:text-text-primary-dark mb-4">Quick Actions</h2>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('questions.downloadTemplate') }}"
                                class="btn-mobile bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700 border border-neutral-300 dark:border-neutral-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Template
                            </a>

                            <button @click="showAudioUploadModal = true"
                                class="btn-mobile bg-teal-500 hover:bg-teal-600 text-white hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 19V6l7-3v13l-7 3zM9 19a2 2 0 11-4 0 2 2 0 014 0zm7-13a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Upload Audio Batch
                            </button>

                            <button @click="showImportModal = true"
                                class="btn-mobile gradient-primary text-white hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                Import Excel
                            </button>
                            <a href="{{ route('manajemen-reading.create') }}"
                                class="btn-mobile gradient-success text-white hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Buat Reading Set
                            </a>
                            <a href="{{ route('questions.create') }}"
                                class="btn-mobile bg-secondary-600 hover:bg-secondary-700 text-white hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Buat Soal Tunggal
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Improved Filter Section -->
            <div class="mb-8">
                <form action="{{ route('questions.index') }}" method="GET">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Filter & Pencarian</h2>
                                </div>
                                <button type="button" @click="showFilters = !showFilters"
                                    class="lg:hidden flex items-center space-x-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                                    <svg class="w-4 h-4 transition-transform duration-200"
                                        x-bind:class="{ 'rotate-180': showFilters }" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                    <span class="text-sm font-medium">Filter</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4"
                                x-bind:class="{ 'hidden lg:grid': !showFilters }">
                                <div>
                                    <label for="test_package_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Test Package
                                    </label>
                                    <select name="test_package_id" id="test_package_id"
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200">
                                        <option value="">Semua Package</option>
                                        @foreach ($testPackages as $package)
                                            <option value="{{ $package->id }}" @selected(request('test_package_id') == $package->id)>
                                                {{ $package->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="section"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Section
                                    </label>
                                    <select name="section" id="section"
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200">
                                        <option value="">Semua Section</option>
                                        <option value="listening" @selected(request('section') == 'listening')>Listening</option>
                                        <option value="structure" @selected(request('section') == 'structure')>Structure</option>
                                        <option value="reading" @selected(request('section') == 'reading')>Reading</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="part"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Part
                                    </label>
                                    <input type="text" name="part" id="part"
                                        placeholder="Contoh: A, B..." value="{{ request('part') }}"
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200">
                                </div>
                                <div>
                                    <label for="search"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Cari Soal
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                        </div>
                                        <input type="text" name="search" id="search"
                                            placeholder="Cari teks soal..." value="{{ request('search') }}"
                                            class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white transition-all duration-200">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-transparent mb-2">Aksi</label>
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modern Table Design -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>#</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <span>Package</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-1.414.586H7a4 4 0 01-4-4V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span>Section</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        <span>Part</span>
                                    </div>
                                </th>
                                {{-- <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Soal</span>
                                    </div>
                                </th> --}}
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                                        </svg>
                                        <span>Audio</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                        </svg>
                                        <span>Aksi</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse($questions as $index => $question)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full">
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $questions->firstItem() + $index }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $question->testPackage->title }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Test Package</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            {{ $question->section == 'listening'
                                                ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300'
                                                : ($question->section == 'structure'
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300'
                                                    : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300') }}">
                                            {{ ucfirst($question->section) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex  ">
                                            <span class="text-sm font-bold text-black dark:text-gray-900">{{ $question->part }}</span>
                                        </div>
                                    </td>
                                    {{-- <td class="px-6 py-4">
                                        <div class="max-w-xs">
                                            <div class="text-sm text-gray-900 dark:text-white line-clamp-2"
                                                title="{{ $question->question_text }}">
                                                {{ Str::limit($question->question_text, 60) }}
                                            </div>
                                        </div>
                                    </td> --}}
                                    <td class="px-6 py-4">
                                        @if ($question->audio_file_path)
                                            <button
                                                @click="playAudio('{{ asset('storage/' . $question->audio_file_path) }}')"
                                                class="inline-flex items-center justify-center w-9 h-9 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105 shadow-sm">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.798l-4.316-3.162A1 1 0 014 13v-2a1 1 0 01.067-.636l4.316-3.162zM16 7a3 3 0 000 6V7zM15.072 2.804A7.001 7.001 0 0118 9v2a7.001 7.001 0 01-2.928 6.196c-.348.295-.852.028-.852-.474V3.278c0-.502.504-.769.852-.474z" />
                                                </svg>
                                            </button>
                                        @else
                                            <div class="inline-flex items-center justify-center w-9 h-9 bg-gray-100 dark:bg-gray-700 rounded-xl">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('questions.show', $question) }}" title="Lihat Detail"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('questions.edit', $question) }}" title="Edit Soal"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <button
                                                @click="deleteQuestion('{{ route('questions.destroy', $question->id) }}')" title="Hapus Soal"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">
                                                Belum Ada Soal
                                            </h3>
                                            <p class="text-gray-500 dark:text-gray-400 max-w-md text-center">
                                                Belum ada soal yang tersedia atau sesuai dengan filter yang dipilih. Mulai dengan membuat soal baru atau impor dari Excel.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($questions->hasPages())
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                        {{ $questions->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal Import Excel -->
        <div x-show="showImportModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.outside="showImportModal = false"
                class="bg-white dark:bg-neutral-800 rounded-2xl p-6 w-full max-w-screen-md mx-4 animate-bounce-in">
                <h3 class="text-xl font-semibold text-text-primary dark:text-text-primary-dark mb-6">Import Soal dari Excel</h3>
                <form @submit.prevent="handleImport">
                    <div class="mb-6">
                        <label for="import_test_package_id"
                            class="block text-sm font-medium text-black dark:text-black-dark mb-2">Test Package</label>
                        <select x-model="importData.test_package_id" id="import_test_package_id" required
                            class="w-full px-4 py-3 bg-surface dark:bg-surface-dark border border-border dark:border-border-dark rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-text-primary dark:text-text-primary-dark">
                            <option value="">Pilih Test Package</option>
                            @foreach ($testPackages as $package)
                                <option value="{{ $package->id }}">{{ $package->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="file_soal"
                            class="block text-sm font-medium text-black dark:text-black-dark mb-2">File Excel</label>
                        <input type="file" @change="importData.file = $event.target.files[0]" id="file_soal" accept=".xlsx,.csv" required
                            class="w-full text-sm text-text-primary dark:text-text-primary-dark file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-300">
                    </div>
                    <div class="mb-6 text-center">
                        <a href="{{ route('questions.downloadTemplate') }}"
                            class="text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 hover:underline">
                            Download Template Excel
                        </a>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="showImportModal = false"
                            class="btn-mobile bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700">
                            Batal
                        </button>
                        <button type="submit" :disabled="importData.loading"
                            class="btn-mobile gradient-primary text-white hover:shadow-lg disabled:opacity-50">
                            <span x-show="!importData.loading">Import</span>
                            <span x-show="importData.loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Upload Audio -->
        <div x-show="showAudioUploadModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.outside="showAudioUploadModal = false"
                class="bg-white dark:bg-neutral-800 rounded-2xl p-6 w-full max-w-screen-4xl mx-4 animate-bounce-in max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-text-primary dark:text-text-primary-dark">Kelola File Audio</h3>
                    <button @click="showAudioUploadModal = false" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Tabs -->
                <div class="mb-6">
                    <div class="flex space-x-1 bg-neutral-100 dark:bg-neutral-700 rounded-lg p-1">
                        <button @click="audioTab = 'upload'" 
                            :class="audioTab === 'upload' ? 'bg-white dark:bg-neutral-800 text-primary-600 dark:text-primary-400' : 'text-neutral-600 dark:text-neutral-400'"
                            class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200">
                            Upload File
                        </button>
                        <button @click="audioTab = 'manage'" 
                            :class="audioTab === 'manage' ? 'bg-white dark:bg-neutral-800 text-primary-600 dark:text-primary-400' : 'text-neutral-600 dark:text-neutral-400'"
                            class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200"
                            @click="loadAudioFiles()">
                            Kelola File
                        </button>
                    </div>
                </div>

                <!-- Tab Upload -->
                <div x-show="audioTab === 'upload'" x-transition>
                    <form @submit.prevent="handleAudioUpload">
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-black dark:text-black-dark mb-2">
                                Pilih File Audio (MP3, WAV, OGG)
                            </label>
                            <input type="file" 
                                @change="audioData.files = Array.from($event.target.files)"
                                multiple accept=".mp3,.wav,.ogg" 
                                class="w-full text-sm text-text-primary dark:text-text-primary-dark file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-300">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 10MB per file. Anda dapat memilih multiple file sekaligus.</p>
                        </div>

                        <div x-show="audioData.files.length > 0" class="mb-6">
                            <h4 class="text-sm font-medium text-black dark:text-black-dark mb-2">File yang dipilih:</h4>
                            <div class="max-h-32 overflow-y-auto">
                                <template x-for="(file, index) in audioData.files" :key="index">
                                    <div class="flex items-center justify-between p-2 bg-neutral-50 dark:bg-neutral-700 rounded-lg mb-2">
                                        <span class="text-sm text-text-primary dark:text-text-primary-dark" x-text="file.name"></span>
                                        <span class="text-xs text-gray-500" x-text="formatFileSize(file.size)"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="audioData.files = []"
                                class="btn-mobile bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700">
                                Reset
                            </button>
                            <button type="submit" :disabled="audioData.loading || audioData.files.length === 0"
                                class="btn-mobile gradient-primary text-white hover:shadow-lg disabled:opacity-50">
                                <span x-show="!audioData.loading">Upload Audio</span>
                                <span x-show="audioData.loading" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Uploading...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab Manage -->
                <div x-show="audioTab === 'manage'" x-transition>
                    <div class="mb-4 flex justify-between items-center">
                        <h4 class="text-sm font-medium text-black dark:text-black-dark">File Audio yang Tersedia</h4>
                        <div class="space-x-2">
                            <button @click="loadAudioFiles()" 
                                class="btn-mobile bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700 text-xs">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Refresh
                            </button>
                            <button @click="cleanupAudioFiles()" 
                                class="btn-mobile bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/50 text-xs">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Cleanup
                            </button>
                        </div>
                    </div>

                    <div x-show="audioFiles.loading" class="text-center py-8">
                        <svg class="animate-spin h-8 w-8 text-primary-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Memuat file audio...</p>
                    </div>

                    <div x-show="!audioFiles.loading && audioFiles.list.length === 0" class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l7-3v13l-7 3zM9 19a2 2 0 11-4 0 2 2 0 014 0zm7-13a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-sm text-gray-500">Belum ada file audio yang di-upload</p>
                    </div>

                    <div x-show="!audioFiles.loading && audioFiles.list.length > 0" class="max-h-96 overflow-y-auto">
                        <template x-for="file in audioFiles.list" :key="file.name">
                            <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-700 rounded-lg mb-2">
                                <div class="flex-1">
                                    <div class="font-medium text-sm text-text-primary dark:text-text-primary-dark" x-text="file.name"></div>
                                    <div class="text-xs text-gray-500">
                                        <span x-text="file.size_formatted"></span> • 
                                        <span x-text="file.uploaded_at_formatted"></span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button @click="playAudioFile(file.name)" 
                                        class="p-1 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded hover:bg-primary-200 dark:hover:bg-primary-900/50">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.798l-4.316-3.162A1 1 0 014 13v-2a1 1 0 01.067-.636l4.316-3.162zM16 7a3 3 0 000 6V7z"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteAudioFile(file.name)" 
                                        class="p-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded hover:bg-red-200 dark:hover:bg-red-900/50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Toast Notifications -->
        <div x-show="toast.show" x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-x-0 opacity-100"
             x-transition:leave-end="translate-x-full opacity-0"
             class="fixed top-6 right-20 z-50 max-w-screen-sm w-full">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden backdrop-blur-xl"
                :class="{
                    'border-l-4 border-l-green-500': toast.type === 'success',
                    'border-l-4 border-l-red-500': toast.type === 'error',
                    'border-l-4 border-l-yellow-500': toast.type === 'warning',
                    'border-l-4 border-l-blue-500': toast.type === 'info'
                }">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                :class="{
                                    'bg-green-100 dark:bg-green-900/30': toast.type === 'success',
                                    'bg-red-100 dark:bg-red-900/30': toast.type === 'error',
                                    'bg-yellow-100 dark:bg-yellow-900/30': toast.type === 'warning',
                                    'bg-blue-100 dark:bg-blue-900/30': toast.type === 'info'
                                }">
                                <svg x-show="toast.type === 'success'" class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <svg x-show="toast.type === 'error'" class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <svg x-show="toast.type === 'warning'" class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <svg x-show="toast.type === 'info'" class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                <span x-show="toast.type === 'success'">Berhasil!</span>
                                <span x-show="toast.type === 'error'">Error!</span>
                                <span x-show="toast.type === 'warning'">Peringatan!</span>
                                <span x-show="toast.type === 'info'">Info</span>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300" x-text="toast.message">
                            </div>
                        </div>
                        <button @click="hideToast()" class="ml-4 flex-shrink-0 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                            <div class="h-1 rounded-full animate-pulse"
                                :class="{
                                    'bg-green-500': toast.type === 'success',
                                    'bg-red-500': toast.type === 'error', 
                                    'bg-yellow-500': toast.type === 'warning',
                                    'bg-blue-500': toast.type === 'info'
                                }"
                                style="animation: shrink 5s linear forwards;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <audio x-ref="audioPlayer" preload="none"></audio>

    <style>
        @keyframes shrink {
            from { width: 100%; }
            to { width: 0%; }
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        function questionsIndex() {
            return {
                showImportModal: false,
                showAudioUploadModal: false,
                showFilters: false,
                audioTab: 'upload',
                currentAudio: null,
                
                // Import data
                importData: {
                    test_package_id: '',
                    file: null,
                    loading: false
                },
                
                // Audio upload data
                audioData: {
                    files: [],
                    loading: false
                },
                
                // Audio files list
                audioFiles: {
                    list: [],
                    loading: false
                },
                
                // Toast notifications
                toast: {
                    show: false,
                    type: 'info',
                    message: ''
                },

                init() {
                    // Check for session messages and show as toast
                    @if(session('success'))
                        this.showToast('success', '{{ session('success') }}');
                    @endif
                    @if(session('error'))
                        this.showToast('error', '{{ session('error') }}');
                    @endif
                    @if(session()->has('import_errors'))
                        let errorMessage = 'Import gagal! ';
                        @foreach(session()->get('import_errors') as $failure)
                            errorMessage += 'Baris {{ $failure->row() }}: {{ $failure->errors()[0] }} ';
                        @endforeach
                        this.showToast('error', errorMessage);
                    @endif
                },

                // Toast functions
                showToast(type, message) {
                    this.toast = { show: true, type, message };
                    setTimeout(() => this.hideToast(), 5000);
                },

                hideToast() {
                    this.toast.show = false;
                },

                // Format file size
                formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                },

                // Audio functions
                playAudio(audioUrl) {
                    const audio = this.$refs.audioPlayer;
                    if (audio.src !== audioUrl) {
                        audio.src = audioUrl;
                        this.currentAudio = audio;
                        audio.play();
                    } else {
                        if (audio.paused) {
                            audio.play();
                        } else {
                            audio.pause();
                        }
                    }
                    audio.onended = () => {
                        this.currentAudio = null;
                    };
                },

                playAudioFile(filename) {
                    this.playAudio(`{{ asset('storage/import_audio') }}/${filename}`);
                },

                // Import functions
             // Di dalam x-data="questionsIndex()"

// ... (fungsi lainnya biarkan) ...

// Ganti fungsi handleImport yang lama dengan yang ini
async handleImport() {
    if (!this.importData.test_package_id || !this.importData.file) {
        this.showToast('error', 'Harap pilih test package dan file Excel');
        return;
    }

    this.importData.loading = true;
    const formData = new FormData();
    formData.append('test_package_id', this.importData.test_package_id);
    formData.append('file_soal', this.importData.file);
    // CSRF token tidak perlu di append manual jika menggunakan header X-CSRF-TOKEN
    
    try {
        const response = await fetch('{{ route("questions.import.store") }}', {
            method: 'POST',
            headers: {
                // Header ini penting agar Laravel tahu ini request AJAX
                'Accept': 'application/json', 
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });

        const result = await response.json();

        if (!response.ok) {
            // Jika status response bukan 2xx (misal 422 atau 500), lempar error
            throw result;
        }

        // Jika response.ok, berarti SUKSES
        this.showToast('success', result.message);
        this.showImportModal = false;
        this.importData = { test_package_id: '', file: null, loading: false };
        // Reload halaman setelah 1.5 detik untuk menampilkan data baru
        setTimeout(() => window.location.reload(), 1500);

    } catch (error) {
        // Blok ini akan menangani semua jenis kegagalan
        let errorMessage = error.message || 'Terjadi kesalahan tidak diketahui.';

        // Cek jika ada detail error validasi dari Maatwebsite/Excel
        if (error.errors) {
            errorMessage = `<strong>${error.message}</strong><br><ul class="list-disc pl-5 mt-2">`;
            error.errors.forEach(failure => {
                errorMessage += `<li><strong>Baris ${failure.row}:</strong> ${failure.errors[0]}</li>`;
            });
            errorMessage += '</ul>';
        }

        // Tampilkan pesan error yang sebenarnya menggunakan sistem toast Anda
        this.showToast('error', errorMessage);
    } finally {
        this.importData.loading = false;
    }
},

// ... (sisa fungsi lainnya) ...

                // Audio upload functions
                async handleAudioUpload() {
                    if (this.audioData.files.length === 0) {
                        this.showToast('error', 'Harap pilih file audio');
                        return;
                    }

                    this.audioData.loading = true;
                    const formData = new FormData();
                    
                    this.audioData.files.forEach(file => {
                        formData.append('audio_files[]', file);
                    });
                    formData.append('_token', '{{ csrf_token() }}');

                    try {
                        const response = await fetch('{{ route("questions.audio.upload") }}', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();
                        
                        if (result.success) {
                            this.showToast('success', result.message);
                            this.audioData.files = [];
                            this.loadAudioFiles(); // Refresh list
                        } else {
                            this.showToast('error', result.message);
                        }
                    } catch (error) {
                        this.showToast('error', 'Terjadi kesalahan: ' + error.message);
                    } finally {
                        this.audioData.loading = false;
                    }
                },

                // Load audio files
                async loadAudioFiles() {
                    this.audioFiles.loading = true;
                    
                    try {
                        const response = await fetch('{{ route("questions.audio.files") }}');
                        const result = await response.json();
                        
                        if (result.success) {
                            this.audioFiles.list = result.data;
                        } else {
                            this.showToast('error', 'Gagal memuat daftar file audio');
                        }
                    } catch (error) {
                        this.showToast('error', 'Terjadi kesalahan: ' + error.message);
                    } finally {
                        this.audioFiles.loading = false;
                    }
                },

                // Delete audio file
                async deleteAudioFile(filename) {
                    if (!confirm(`Apakah Anda yakin ingin menghapus file "${filename}"?`)) return;

                    try {
                        const response = await fetch('{{ route("questions.audio.delete") }}', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ filename })
                        });

                        const result = await response.json();
                        
                        if (result.success) {
                            this.showToast('success', result.message);
                            this.loadAudioFiles(); // Refresh list
                        } else {
                            this.showToast('error', result.message);
                        }
                    } catch (error) {
                        this.showToast('error', 'Terjadi kesalahan: ' + error.message);
                    }
                },

                // Cleanup unused audio files
                async cleanupAudioFiles() {
                    if (!confirm('Apakah Anda yakin ingin menghapus semua file audio yang tidak terpakai (lebih dari 7 hari)?')) return;

                    try {
                        const response = await fetch('{{ route("questions.audio.cleanup") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const result = await response.json();
                        
                        if (result.success) {
                            this.showToast('success', result.message);
                            this.loadAudioFiles(); // Refresh list
                        } else {
                            this.showToast('error', result.message);
                        }
                    } catch (error) {
                        this.showToast('error', 'Terjadi kesalahan: ' + error.message);
                    }
                },

                // Delete question
                deleteQuestion(deleteUrl) {
                    if (confirm('Apakah Anda yakin ingin menghapus soal ini? Tindakan ini tidak dapat dibatalkan.')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = deleteUrl;
                        form.innerHTML = '@csrf @method("DELETE")';
                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            }
        }
    </script>
</x-layout>