<x-layout>
    <div class="container mx-auto px-4 py-8" x-data="questionsEdit()">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Soal</h1>
            <a href="{{ route('questions.index') }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-400">←
                Kembali</a>
        </div>

        @php
            $choiceMap = ['A', 'B', 'C', 'D'];
            $choicesData = [];
            $correctChoiceLetter = '';
            foreach ($question->choices as $index => $choice) {
                if (isset($choiceMap[$index])) {
                    $letter = $choiceMap[$index];
                    $choicesData[$letter] = $choice->choice_text;
                    if ($choice->is_correct) {
                        $correctChoiceLetter = $letter;
                    }
                }
            }
        @endphp

        <form action="{{ route('questions.update', $question) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="test_package_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Test Package <span
                                class="text-red-500">*</span></label>
                        <select name="test_package_id" id="test_package_id" required x-model="selectedTestPackageId"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            @foreach ($testPackages as $package)
                                <option value="{{ $package->id }}">{{ $package->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="section"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Section</label>
                        <input type="text" id="section" value="{{ ucfirst($question->section) }}" readonly
                            class="w-full px-3 py-2 border-gray-300 bg-gray-100 dark:bg-gray-900 dark:border-gray-600 rounded-lg">
                        <input type="hidden" name="section" value="{{ $question->section }}">
                    </div>
                    <div>
                        <label for="part"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Part <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="part" id="part" value="{{ old('part', $question->part) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div x-show="selectedSection === 'reading'" x-transition class="mb-6">
                    <label for="reading_passage_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Teks Bacaan <span
                            class="text-red-500">*</span></label>
                    <select name="reading_passage_id" id="reading_passage_id" :disabled="!selectedTestPackageId"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white disabled:bg-gray-100 dark:disabled:bg-gray-800">
                        <option value="">Pilih Test Package terlebih dahulu</option>
                        <template x-for="passage in filteredPassages" :key="passage.id">
                            <option :value="passage.id" x-text="passage.title"
                                :selected="passage.id == selectedPassageId"></option>
                        </template>
                    </select>
                </div>

                <div x-show="selectedSection === 'listening'" x-transition class="mb-6">
                    <label for="audio_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">File
                        Audio (Opsional)</label>
                    @if ($question->audio_file_path)
                        <div class="my-2 p-2 bg-gray-100 dark:bg-gray-700 rounded">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Audio saat ini:</p>
                            <audio controls class="w-full"
                                src="{{ asset('storage/' . $question->audio_file_path) }}"></audio>
                        </div>
                    @endif
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4">
                        <input type="file" name="audio_file" id="audio_file" accept=".mp3,.wav,.ogg"
                            class="w-full text-sm text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Upload file baru untuk mengganti audio
                            yang sudah ada.</p>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="question_text"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teks Soal <span
                            class="text-red-500">*</span></label>
                    <textarea name="question_text" id="question_text" rows="4" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white resize-y">{{ old('question_text', $question->question_text) }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Pilihan Jawaban <span
                            class="text-red-500">*</span></label>
                    <div class="space-y-4">
                        @foreach ($choiceMap as $choiceLetter)
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="correct_answer" value="{{ $choiceLetter }}"
                                    id="choice_{{ $choiceLetter }}" @checked(old('correct_answer', $correctChoiceLetter) == $choiceLetter)
                                    class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                <label for="choice_{{ $choiceLetter }}"
                                    class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center text-sm font-medium cursor-pointer flex-shrink-0"><span>{{ $choiceLetter }}</span></label>
                                <input type="text" name="choices[{{ $choiceLetter }}]"
                                    value="{{ old('choices.' . $choiceLetter, $choicesData[$choiceLetter] ?? '') }}"
                                    placeholder="Teks Pilihan {{ $choiceLetter }}"
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <a href="{{ route('questions.index') }}"
                        class="px-6 py-2 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">Update
                        Soal</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function questionsEdit() {
            return {
                selectedSection: '{{ $question->section }}',
                selectedTestPackageId: '{{ old('test_package_id', $question->test_package_id) }}',
                selectedPassageId: '{{ old('reading_passage_id', $question->reading_passage_id) }}',
                allPassages: @json($readingPassages),

                get filteredPassages() {
                    if (!this.selectedTestPackageId) {
                        return [];
                    }
                    return this.allPassages.filter(
                        p => p.test_package_id == this.selectedTestPackageId
                    );
                }
            }
        }
    </script>
</x-layout>
