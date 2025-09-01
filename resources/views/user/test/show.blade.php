<x-layout>
    <div class="flex flex-col md:flex-row h-screen bg-gray-100">

        <main class="flex-1 p-6 md:p-10 overflow-y-auto">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full  mx-auto">

                {{-- Header: Section, Part, and Timer --}}
                <div class="flex justify-between items-center border-b pb-4 mb-6">
                    <div>
                        <span class="text-sm font-semibold text-gray-500 uppercase">{{ $question->section }} -
                            {{ $question->part }}</span>
                        <h2 class="text-xl font-bold">Soal Nomor
                            {{ $allQuestions->search(function ($item) use ($question) {return $item->id == $question->id;}) + 1 }}
                        </h2>
                    </div>
                    <div id="timer" class="text-2xl font-bold text-red-600 bg-red-100 px-4 py-2 rounded-lg">
                        --:--
                    </div>
                </div>

                {{-- Reading Passage (if any) --}}
                @if ($question->readingPassage)
                    <div class="mb-6 p-4 bg-gray-50 rounded-md border max-h-64 overflow-y-auto">
                        <h3 class="font-bold mb-2">{{ $question->readingPassage->title }}</h3>
                        <div class="prose max-w-none">
                            {!! nl2br(e($question->readingPassage->passage_text)) !!}
                        </div>
                    </div>
                @endif

                {{-- Audio Player (if any) --}}
                @if ($question->audio_file_path)
                    <div class="mb-6">
                        <audio controls class="w-full">
                            <source src="{{ asset('storage/' . $question->audio_file_path) }}" type="audio/mpeg">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>
                    </div>
                @endif

                {{-- Question Text --}}
                <div class="text-lg mb-6">
                    {!! nl2br(e($question->question_text)) !!}
                </div>

                {{-- Choices Form --}}
                <form id="answer-form" action="{{ route('user.test.answer.store', [$session, $question]) }}"
                    method="POST">
                    @csrf
                    <div class="space-y-4">
                        @foreach ($question->choices as $choice)
                            <label class="flex items-center p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="selected_choice_id" value="{{ $choice->id }}"
                                    class="mr-4" {{-- Check jika sudah pernah dijawab --}}
                                    @if ($currentAnswer && $currentAnswer->selected_choice_id == $choice->id) checked @endif required>
                                <span>{{ $choice->choice_text }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg">
                            Simpan & Lanjutkan
                        </button>
                    </div>
                </form>

            </div>
        </main>

        <aside class="w-full md:w-64 bg-white p-6 shadow-lg overflow-y-auto">
            <h3 class="text-lg font-bold mb-4 text-center">Navigasi Soal</h3>
            <div class="grid grid-cols-5 gap-2 mb-6">
                @foreach ($allQuestions as $index => $q)
                    <a href="{{ route('user.test.show', [$session, $q]) }}"
                        class="flex items-center justify-center h-10 w-10 rounded-md text-white font-bold
                            @if ($q->id == $question->id) ring-2 ring-indigo-500 @endif
                            {{ in_array($q->id, $answeredQuestionIds) ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}">
                        {{ $index + 1 }}
                    </a>
                @endforeach
            </div>

            <hr class="my-6">

            <form action="{{ route('user.test.finish', $session) }}" method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan tes ini? Jawaban tidak dapat diubah kembali.');">
                @csrf
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg">
                    Selesaikan Tes
                </button>
            </form>
        </aside>
    </div>

    <script>
        // SCRIPT UNTUK TIMER
        const timerElement = document.getElementById('timer');
        const finishForm = document.getElementById('finish-form');
        const endTime = new Date("{{ $endTime->toIso8601String() }}").getTime();

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                timerElement.innerHTML = "WAKTU HABIS";
                // Otomatis submit form finish
                alert('Waktu pengerjaan telah habis. Tes akan diselesaikan secara otomatis.');
                document.querySelector('form[action="{{ route('user.test.finish', $session) }}"]').submit();
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tambahkan padStart untuk format 00:00
            const displayMinutes = String(minutes).padStart(2, '0');
            const displaySeconds = String(seconds).padStart(2, '0');

            timerElement.innerHTML = `${displayMinutes}:${displaySeconds}`;

        }, 1000);
    </script>
</x-layout>
