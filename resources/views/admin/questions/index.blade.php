<x-layout>
    <div class=" bg-background dark:bg-background-dark" x-data="questionsIndex()">
        <!-- Hero Header Section -->
        <div class="bg-gradient-primary relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
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

        <!-- Main Content -->
        <div class="max-w-screen-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10">
            <!-- Notification Section -->
            <div class="mb-6">
                @if (session('success'))
                    <div
                        class="bg-accent-50 dark:bg-accent-900/20 border-l-4 border-accent-500 p-4 rounded-xl animate-fade-in">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-accent-800 dark:text-accent-200 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="bg-danger-50 dark:bg-danger-900/20 border-l-4 border-danger-500 p-4 rounded-xl animate-fade-in">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-danger-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-danger-800 dark:text-danger-200 font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session()->has('import_errors'))
                    <div
                        class="bg-danger-50 dark:bg-danger-900/20 border-l-4 border-danger-500 p-4 rounded-xl animate-fade-in">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-danger-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-danger-800 dark:text-danger-200 font-medium">Import Gagal!</h3>
                                <div class="mt-2 text-sm text-danger-700 dark:text-danger-300">
                                    <p class="mb-2">Ada kesalahan dalam file Excel Anda:</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach (session()->get('import_errors') as $failure)
                                            <li>
                                                <strong>Baris {{ $failure->row() }}:</strong>
                                                {{ $failure->errors()[0] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="mb-8">
                <div class="card-mobile-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-text-primary dark:text-text-primary-dark mb-4">Quick
                            Actions</h2>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('questions.downloadTemplate') }}"
                                class="btn-mobile bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700 border border-neutral-300 dark:border-neutral-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Template
                            </a>
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

            <!-- Content continues with filters and table sections -->
            <div class="mb-8">
                <form action="{{ route('questions.index') }}" method="GET">
                    <div class="card-mobile-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-text-primary dark:text-text-primary-dark">Filter
                                    dan Pencarian</h2>
                                <button type="button" @click="showFilters = !showFilters"
                                    class="lg:hidden btn-mobile bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                    <svg class="w-4 h-4 transition-transform duration-200"
                                        x-bind:class="{ 'rotate-180': showFilters }" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4"
                                x-bind:class="{ 'hidden lg:grid': !showFilters }">
                                <div>
                                    <label for="test_package_id"
                                        class="block text-sm font-medium text-text-secondary dark:text-text-secondary-dark mb-2">
                                        Test Package
                                    </label>
                                    <select name="test_package_id" id="test_package_id"
                                        class="w-full px-4 py-3 bg-surface dark:bg-surface-dark border border-border dark:border-border-dark rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-text-primary dark:text-text-primary-dark transition-all duration-200">
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
                                        class="block text-sm font-medium text-text-secondary dark:text-text-secondary-dark mb-2">
                                        Section
                                    </label>
                                    <select name="section" id="section"
                                        class="w-full px-4 py-3 bg-surface dark:bg-surface-dark border border-border dark:border-border-dark rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-text-primary dark:text-text-primary-dark transition-all duration-200">
                                        <option value="">Semua Section</option>
                                        <option value="listening" @selected(request('section') == 'listening')>Listening</option>
                                        <option value="structure" @selected(request('section') == 'structure')>Structure</option>
                                        <option value="reading" @selected(request('section') == 'reading')>Reading</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="part"
                                        class="block text-sm font-medium text-text-secondary dark:text-text-secondary-dark mb-2">
                                        Part
                                    </label>
                                    <input type="text" name="part" id="part"
                                        placeholder="Contoh: A, B..." value="{{ request('part') }}"
                                        class="w-full px-4 py-3 bg-surface dark:bg-surface-dark border border-border dark:border-border-dark rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-text-primary dark:text-text-primary-dark transition-all duration-200">
                                </div>
                                <div>
                                    <label for="search"
                                        class="block text-sm font-medium text-text-secondary dark:text-text-secondary-dark mb-2">
                                        Cari Soal
                                    </label>
                                    <input type="text" name="search" id="search"
                                        placeholder="Cari teks soal..." value="{{ request('search') }}"
                                        class="w-full px-4 py-3 bg-surface dark:bg-surface-dark border border-border dark:border-border-dark rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-text-primary dark:text-text-primary-dark transition-all duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-transparent mb-2">Aksi</label>
                                    <button type="submit"
                                        class="w-full btn-mobile gradient-primary text-white hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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

            <!-- Questions Table -->
            <div class="card-mobile-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-text-secondary dark:text-text-secondary-dark uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-text-secondary dark:text-text-secondary-dark uppercase tracking-wider">
                                    Package</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-text-secondary dark:text-text-secondary-dark uppercase tracking-wider">
                                    Section</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-text-secondary dark:text-text-secondary-dark uppercase tracking-wider">
                                    Part</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-text-secondary dark:text-text-secondary-dark uppercase tracking-wider">
                                    Soal</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-text-secondary dark:text-text-secondary-dark uppercase tracking-wider">
                                    Audio</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-text-secondary dark:text-text-secondary-dark uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border dark:divide-border-dark">
                            @forelse($questions as $index => $question)
                                <tr
                                    class="hover:bg-neutral-50 dark:hover:bg-neutral-800/30 transition-colors duration-200">
                                    <td
                                        class="px-6 py-4 text-sm font-medium text-text-primary dark:text-text-primary-dark">
                                        {{ $questions->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-text-primary dark:text-text-primary-dark">
                                            {{ $question->testPackage->title }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            {{ $question->section == 'listening'
                                                ? 'bg-primary-100 text-primary-800 dark:bg-primary-900/30 dark:text-primary-300'
                                                : ($question->section == 'structure'
                                                    ? 'bg-accent-100 text-accent-800 dark:bg-accent-900/30 dark:text-accent-300'
                                                    : 'bg-secondary-100 text-secondary-800 dark:bg-secondary-900/30 dark:text-secondary-300') }}">
                                            {{ ucfirst($question->section) }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm font-bold text-text-primary dark:text-text-primary-dark">
                                        {{ $question->part }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-text-primary dark:text-text-primary-dark max-w-screen-md truncate"
                                            title="{{ $question->question_text }}">
                                            {{ Str::limit($question->question_text, 60) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($question->audio_file_path)
                                            <button
                                                @click="playAudio('{{ asset('storage/' . $question->audio_file_path) }}')"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-lg hover:bg-primary-200 dark:hover:bg-primary-900/50 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.798l-4.316-3.162A1 1 0 014 13v-2a1 1 0 01.067-.636l4.316-3.162zM16 7a3 3 0 000 6V7zM15.072 2.804A7.001 7.001 0 0118 9v2a7.001 7.001 0 01-2.928 6.196c-.348.295-.852.028-.852-.474V3.278c0-.502.504-.769.852-.474z" />
                                                </svg>
                                            </button>
                                        @else
                                            <span class="text-text-muted dark:text-text-muted-dark">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('questions.show', $question) }}"
                                                class="text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium text-sm transition-colors duration-200">
                                                Lihat
                                            </a>
                                            <a href="{{ route('questions.edit', $question) }}"
                                                class="text-secondary-600 dark:text-secondary-400 hover:text-secondary-700 dark:hover:text-secondary-300 font-medium text-sm transition-colors duration-200">
                                                Edit
                                            </a>
                                            <button
                                                @click="deleteQuestion('{{ route('questions.destroy', $question->id) }}')"
                                                class="text-danger-600 dark:text-danger-400 hover:text-danger-700 dark:hover:text-danger-300 font-medium text-sm transition-colors duration-200">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-text-muted dark:text-text-muted-dark mb-4"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3
                                                class="text-lg font-medium text-text-primary dark:text-text-primary-dark mb-2">
                                                Belum Ada Soal</h3>
                                            <p class="text-text-secondary dark:text-text-secondary-dark">Belum ada soal
                                                yang tersedia atau sesuai dengan filter yang dipilih.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($questions->hasPages())
                    <div class="px-6 py-4 border-t border-border dark:border-border-dark">
                        {{ $questions->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Import Modal -->
        <div x-show="showImportModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.outside="showImportModal = false"
                class="bg-white dark:bg-neutral-800 rounded-2xl p-6 w-full max-w-screen-md mx-4 animate-bounce-in">
                <h3 class="text-xl font-semibold text-text-primary dark:text-text-primary-dark mb-6">Import Soal dari
                    Excel</h3>
                <form action="{{ route('questions.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label for="import_test_package_id"
                            class="block text-sm font-medium text-text-secondary dark:text-text-secondary-dark mb-2">Test
                            Package</label>
                        <select name="test_package_id" id="import_test_package_id" required
                            class="w-full px-4 py-3 bg-surface dark:bg-surface-dark border border-border dark:border-border-dark rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-text-primary dark:text-text-primary-dark">
                            <option value="">Pilih Test Package</option>
                            @foreach ($testPackages as $package)
                                <option value="{{ $package->id }}">{{ $package->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="file_soal"
                            class="block text-sm font-medium text-text-secondary dark:text-text-secondary-dark mb-2">File
                            Excel</label>
                        <input type="file" name="file_soal" id="file_soal" accept=".xlsx,.csv" required
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
                        <button type="submit" class="btn-mobile gradient-primary text-white hover:shadow-lg">
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <audio x-ref="audioPlayer" preload="none"></audio>

    <script>
        function questionsIndex() {
            return {
                showImportModal: false,
                showFilters: false,
                currentAudio: null,
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
                deleteQuestion(deleteUrl) {
                    if (confirm('Apakah Anda yakin ingin menghapus soal ini? Tindakan ini tidak dapat dibatalkan.')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = deleteUrl;
                        form.innerHTML = '@csrf @method('DELETE')';
                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            }
        }
    </script>
</x-layout>
