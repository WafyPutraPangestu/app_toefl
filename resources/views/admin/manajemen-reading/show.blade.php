<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class=" mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $manajemen_reading->title }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Detail teks bacaan dan soal-soal terkait.</p>
                </div>
                <div class="flex items-center space-x-3 mt-4 md:mt-0">
                    <a href="{{ route('manajemen-reading.index') }}"
                        class="text-gray-600 hover:text-gray-800 dark:text-gray-400">← Kembali</a>
                    <a href="{{ route('manajemen-reading.edit', $manajemen_reading) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium">Edit Teks
                        Ini</a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 space-y-8">
                <!-- Detail Teks -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Isi Teks Bacaan</h3>
                    <div
                        class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border dark:border-gray-700">
                        {!! nl2br(e($manajemen_reading->passage_text)) !!}
                    </div>
                </div>

                <!-- Daftar Soal Terkait -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Soal yang Menggunakan Teks Ini
                        ({{ $manajemen_reading->questions->count() }})</h3>
                    <div class="space-y-4">
                        @forelse($manajemen_reading->questions as $question)
                            <div
                                class="border-l-4 border-blue-500 pl-4 py-2 bg-gray-50 dark:bg-gray-700/50 rounded-r-lg">
                                <p class="text-gray-800 dark:text-gray-200">{{ $loop->iteration }}.
                                    {{ $question->question_text }}</p>
                                <a href="{{ route('questions.edit', $question) }}"
                                    class="text-sm text-blue-600 hover:underline mt-1 inline-block">Edit Soal Ini</a>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">Belum ada soal yang dibuat untuk teks ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
