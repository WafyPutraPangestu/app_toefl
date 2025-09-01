<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class=" mx-auto">
            <!-- Navigasi Breadcrumbs -->
            <nav class="mb-6 text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2">
                    <li class="flex items-center">
                        <a href="{{ route('questions.index') }}"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">Manajemen
                            Soal</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z">
                            </path>
                        </svg>
                        <span class="text-gray-800 dark:text-white font-semibold">Detail Soal</span>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Soal</h1>
                    <div
                        class="flex items-center flex-wrap gap-x-3 gap-y-1 text-sm text-gray-500 dark:text-gray-400 mt-2">
                        <span class="font-semibold">{{ $question->testPackage->title }}</span>
                        <span>&middot;</span>
                        <span>Section: <strong>{{ ucfirst($question->section) }}</strong></span>
                        <span>&middot;</span>
                        <span>Part: <strong>{{ $question->part }}</strong></span>
                    </div>
                </div>
                <div class="flex items-center space-x-3 mt-4 md:mt-0">
                    <a href="{{ route('questions.index') }}"
                        class="text-gray-600 hover:text-gray-800 dark:text-gray-400">← Kembali</a>
                    <a href="{{ route('questions.edit', $question) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium">Edit Soal
                        Ini</a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 space-y-8">
                <!-- Tampilkan Teks Bacaan jika ini soal Reading -->
                @if ($question->section === 'reading' && $question->readingPassage)
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Teks Bacaan:
                            {{ $question->readingPassage->title }}</h3>
                        <div
                            class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border dark:border-gray-700">
                            {!! nl2br(e($question->readingPassage->passage_text)) !!}
                        </div>
                    </div>
                @endif

                <!-- Tampilkan Audio Player jika ini soal Listening -->
                @if ($question->section === 'listening' && $question->audio_file_path)
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Audio</h3>
                        <audio controls class="w-full" src="{{ asset('storage/' . $question->audio_file_path) }}">
                            Browser Anda tidak mendukung audio player.
                        </audio>
                    </div>
                @endif

                <!-- Detail Pertanyaan dan Jawaban -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pertanyaan</h3>
                    <div
                        class="text-lg text-gray-800 dark:text-gray-200 mb-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        {!! nl2br(e($question->question_text)) !!}
                    </div>

                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Pilihan Jawaban:</h4>
                    <div class="space-y-3">
                        @php $choiceMap = ['A', 'B', 'C', 'D']; @endphp
                        @foreach ($question->choices as $index => $choice)
                            <div
                                class="flex items-center space-x-4 p-3 rounded-lg border {{ $choice->is_correct ? 'border-green-500 bg-green-50 dark:bg-green-900/30' : 'border-gray-200 dark:border-gray-700' }}">
                                <div
                                    class="w-8 h-8 flex-shrink-0 rounded-full flex items-center justify-center font-bold text-base {{ $choice->is_correct ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
                                    {{ $choiceMap[$index] ?? '?' }}
                                </div>
                                <span
                                    class="text-gray-800 dark:text-gray-200 flex-grow">{{ $choice->choice_text }}</span>
                                @if ($choice->is_correct)
                                    <div class="ml-auto flex-shrink-0">
                                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
