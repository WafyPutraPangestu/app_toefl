<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 to-accent-50 flex flex-col" x-data="testInterface()">
        <!-- Toast Notification Container -->
        <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
        
        <!-- Modal Container -->
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
             @click.self="showModal = false">
            <div class="bg-white rounded-xl p-6 max-w-screen-md w-full shadow-2xl transform transition-all duration-300"
                 x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L3.316 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2" x-text="modalTitle"></h3>
                    <p class="text-gray-600 mb-6" x-text="modalMessage"></p>
                    <div class="flex gap-3">
                        <button @click="showModal = false" 
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                            Batal
                        </button>
                        <button @click="confirmAction()" 
                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Ya, Selesaikan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <header class="bg-white/80 backdrop-blur-md border-b border-primary-100 sticky top-0 z-fixed safe-top">
            <div class="px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></div>
                            <span class="text-xs font-semibold text-primary-600 uppercase tracking-wide">
                                {{ $question->section }} • {{ $question->part }}
                            </span>
                        </div>
                        <h1 class="text-sm font-bold text-neutral-800 mt-0.5">
                            Soal {{ $allQuestions->search(function ($item) use ($question) {return $item->id == $question->id;}) + 1 }} dari {{ $allQuestions->count() }}
                        </h1>
                    </div>
                    
                    <div class="bg-gray-200 text-black px-3 py-3 rounded-xl shadow-mobile">
                        <div id="timer" class="text-sm font-bold text-center leading-none">--:--</div>
                        <div class="text-xs opacity-90 text-center">sisa waktu</div>
                    </div>
                </div>
                
                <div class="mt-3 bg-neutral-200 rounded-full h-1.5 overflow-hidden">
                    <div id="main-progress-bar" class="bg-gradient-primary h-full progress-smooth">
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 flex flex-col lg:flex-row gap-0 lg:gap-6 lg:p-6">
            <div class="flex-1 flex flex-col">
                <div class="flex-1 px-4 py-6 lg:p-8">
                    <div class="card-mobile-lg max-w-screen-4xl mx-auto px-4 py-4 animate-fade-in">
                        
                        {{-- Reading Passage --}}
                        @if ($question->readingPassage)
                            <div class="mb-6" x-data="{ expanded: false }">
                                <div class="bg-gradient-to-r from-accent-50 to-accent-100 rounded-xl p-4 border border-accent-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-bold text-accent-800">
                                            {{ $question->readingPassage->title }}
                                        </h3>
                                        <button @click="expanded = !expanded" 
                                                class="btn-mobile cursor-pointer bg-accent-100 text-accent-700 hover:bg-accent-200 tap-highlight-none">
                                            <span x-text="expanded ? 'Tutup' : 'Baca'"></span>
                                        </button>
                                    </div>
                                    
                                    <div x-show="expanded" x-collapse class="reading-passage">
                                        <div class="prose prose-sm max-w-none text-neutral-700 leading-relaxed">
                                            {!! nl2br(e($question->readingPassage->passage_text)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Audio Player --}}
                        @if ($question->audio_file_path)
                            <div class="mb-6" x-data="audioPlayer()">
                                <div class="bg-gradient-to-r from-secondary-50 to-secondary-100 rounded-xl p-4 border border-secondary-200">
                                    <div class="flex items-center gap-4">
                                        <button @click="togglePlay()" 
                                                class="audio-control bg-secondary-500 hover:bg-secondary-600 text-white rounded-full flex items-center justify-center tap-highlight-none transition-all duration-200">
                                            <template x-if="!isPlaying">
                                                <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 5v10l7-5z"/>
                                                </svg>
                                            </template>
                                            <template x-if="isPlaying">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M6 4h3v12H6V4zm5 0h3v12h-3V4z"/>
                                                </svg>
                                            </template>
                                        </button>
                                        
                                        <div class="flex-1">
                                            <div class="text-xs font-medium text-secondary-700 mb-1">Audio Soal</div>
                                            <div class="bg-secondary-200 rounded-full h-2 overflow-hidden">
                                                <div class="bg-secondary-500 h-full transition-all duration-300" 
                                                     :style="'width: ' + progress + '%'"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-xs text-secondary-600 font-mono" x-text="currentTime"></div>
                                    </div>
                                    
                                    <audio x-ref="audio" preload="metadata" class="hidden">
                                        <source src="{{ asset('storage/' . $question->audio_file_path) }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            </div>
                        @endif

                        {{-- Question Text --}}
                        <div class="mb-8">
                            <div class="bg-gradient-to-r from-primary-50 to-primary-100 rounded-xl p-6 border border-primary-200">
                                <div class="text-base text-neutral-800 leading-relaxed">
                                    {!! nl2br(e($question->question_text)) !!}
                                </div>
                            </div>
                        </div>

                        {{-- Answer Choices --}}
                        <form id="answer-form" action="{{ route('user.test.answer.store', [$session, $question]) }}" method="POST" 
                              x-data="answerForm()">
                            @csrf
                            <div class="space-y-3">
                                @foreach ($question->choices as $index => $choice)
                                    <label class="answer-option block cursor-pointer tap-highlight-none"
                                           @click="selectAnswer('{{ $choice->id }}')"
                                           :class="selectedAnswer === '{{ $choice->id }}' ? 
                                               'bg-gradient-primary text-white shadow-mobile-lg scale-[1.02]' : 
                                               'bg-white hover:bg-primary-50 hover:border-primary-300'"
                                           class="border-2 border-neutral-200 rounded-xl p-4 transition-all duration-200">
                                        <div class="flex items-center py-2 px-2 gap-4">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold"
                                                 :class="selectedAnswer === '{{ $choice->id }}' ? 
                                                     'bg-primary-100 text-primary-700' :
                                                     'bg-primary-100 text-primary-700'">
                                                {{ chr(65 + $index) }}
                                            </div>
                                            <div class="flex-1 text-sm leading-relaxed"
                                                 :class="selectedAnswer === '{{ $choice->id }}' ? 'text-black' : 'text-neutral-700'">
                                                {{ $choice->choice_text }}
                                            </div>
                                            <input type="radio" name="selected_choice_id" value="{{ $choice->id }}"
                                                   class="sr-only"
                                                   @if ($currentAnswer && $currentAnswer->selected_choice_id == $choice->id) checked @endif>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-8 text-center">
                                <button type="submit" 
                                        :disabled="!selectedAnswer"
                                        class="btn-mobile-lg cursor-pointer gradient-primary text-white shadow-mobile-lg disabled:opacity-50 disabled:cursor-not-allowed min-w-48"
                                        :class="selectedAnswer ? 'animate-bounce-in' : ''">
                                    <span class="flex items-center justify-center gap-2">
                                        Simpan & Lanjutkan
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:hidden" x-data="{ showNav: false }">
                <button @click="showNav = true" 
                        class="fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-full shadow-lg z-fixed tap-highlight-none transition-all duration-300 hover:scale-105">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-4 h-3 flex flex-col justify-between">
                            <div class="h-0.5 bg-white rounded"></div>
                            <div class="h-0.5 bg-white rounded"></div>
                            <div class="h-0.5 bg-white rounded"></div>
                        </div>
                        <span class="text-xs mt-1 font-medium">Menu</span>
                    </div>
                </button>

                <div x-show="showNav" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="transform translate-y-full"
                     x-transition:enter-end="transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="transform translate-y-0"
                     x-transition:leave-end="transform translate-y-full"
                     class="fixed inset-x-0 bottom-0 z-modal bg-white rounded-t-3xl shadow-2xl safe-bottom">
                    
                    <div class="flex justify-center pt-3 pb-2">
                        <div class="w-10 h-1 bg-neutral-300 rounded-full"></div>
                    </div>
                    
                    <div class="px-6 pb-6 max-h-96 overflow-y-auto">
                        <div class="text-center mb-6">
                            <h3 class="text-lg font-bold text-neutral-800">Navigasi Soal</h3>
                            <p class="text-sm text-neutral-600 mt-1">
                                {{ count($answeredQuestionIds) }}/{{ $allQuestions->count() }} terjawab
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-6 gap-2 mb-6">
                            @foreach ($allQuestions as $index => $q)
                                <a href="{{ route('user.test.show', [$session, $q]) }}" 
                                   @click="showNav = false"
                                   class="relative w-12 h-12 rounded-xl text-white font-bold text-sm flex items-center justify-center tap-highlight-none transition-all duration-200
                                          @if ($q->id == $question->id) ring-2 ring-primary-400 ring-offset-2 scale-110 @endif
                                          {{ in_array($q->id, $answeredQuestionIds) ? 'bg-green-500 hover:bg-green-600 shadow-mobile' : 'bg-gradient-to-br from-neutral-400 to-neutral-500 hover:from-neutral-500 hover:to-neutral-600 shadow-mobile' }}">
                                    {{ $index + 1 }}
                                    @if ($q->id == $question->id)
                                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-primary-500 rounded-full border-2 border-white"></div>
                                    @endif
                                </a>
                            @endforeach
                        </div>

                        <div class="space-y-3">
                            <button @click="showNav = false" 
                                    class="w-full btn-mobile-lg bg-neutral-200 text-neutral-700 hover:bg-neutral-300">
                                Tutup Menu
                            </button>
                            
                            <button @click="showFinishModal()" 
                                    class="w-full cursor-pointer btn-mobile-lg gradient-danger text-white shadow-mobile-lg">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Selesaikan Tes
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div x-show="showNav" 
                     @click="showNav = false"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     ></div>
            </div>

            <aside class="hidden lg:block w-80 bg-white/80 backdrop-blur-md rounded-2xl shadow-mobile-lg p-6 h-fit sticky top-24">
                <h3 class="text-lg font-bold mb-6 text-center text-neutral-800">Navigasi Soal</h3>
                
                <div class="mb-6 p-4 bg-gradient-to-r from-primary-50 to-accent-50 rounded-xl border border-primary-200">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary-700">
                            {{ count($answeredQuestionIds) }}<span class="text-sm">/{{ $allQuestions->count() }}</span>
                        </div>
                        <div class="text-xs text-primary-600 mt-1">Soal Terjawab</div>
                    </div>
                </div>
                
                <div class="grid grid-cols-6 gap-2 mb-6 max-h-64 overflow-y-auto">
                    @foreach ($allQuestions as $index => $q)
                        <a href="{{ route('user.test.show', [$session, $q]) }}"
                           class="relative w-10 h-10 rounded-lg text-white font-bold text-xs flex items-center justify-center tap-highlight-none transition-all duration-200 hover:scale-105
                                  @if ($q->id == $question->id) ring-2 ring-primary-400 ring-offset-2 scale-110 @endif
                                  {{ in_array($q->id, $answeredQuestionIds) ? 'bg-green-500 hover:bg-green-600 shadow-mobile' : 'bg-gradient-to-br from-neutral-400 to-neutral-500 hover:from-neutral-500 hover:to-neutral-600 shadow-mobile' }}">
                            {{ $index + 1 }}
                            @if ($q->id == $question->id)
                                <div class="absolute -top-1 -right-1 w-2 h-2 bg-primary-500 rounded-full border border-white"></div>
                            @endif
                        </a>
                    @endforeach
                </div>

                <div class="border-t border-neutral-200 pt-6">
                    <button @click="showFinishModal()" 
                            class="w-full btn-mobile-lg cursor-pointer gradient-danger text-white shadow-mobile-lg">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Selesaikan Tes
                        </span>
                    </button>
                </div>
            </aside>
        </main>

        <!-- Hidden form untuk submit finish test -->
        <form id="finish-test-form" action="{{ route('user.test.finish', $session) }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>

    <script>
        // Toast Notification Function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `transform transition-all duration-300 ease-in-out translate-x-full`;
            
            const bgColor = type === 'success' ? 'bg-green-500' : 
                           type === 'error' ? 'bg-red-500' : 
                           type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
            
            toast.innerHTML = `
                <div class="${bgColor} text-white px-6 py-4 rounded-lg shadow-lg max-w-screen-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            ${type === 'success' ? 
                                '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>' :
                                '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>'
                            }
                        </div>
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                </div>
            `;
            
            document.getElementById('toast-container').appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
                toast.classList.add('translate-x-0');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }

        // Alpine.js Components
        function testInterface() {
            return {
                showModal: false,
                modalTitle: '',
                modalMessage: '',
                confirmCallback: null,
                
                showFinishModal() {
                    this.modalTitle = 'Selesaikan Tes';
                    this.modalMessage = 'Apakah Anda yakin ingin menyelesaikan tes ini? Jawaban tidak dapat diubah kembali.';
                    this.confirmCallback = () => {
                        document.getElementById('finish-test-form').submit();
                    };
                    this.showModal = true;
                },
                
                confirmAction() {
                    if (this.confirmCallback) {
                        this.confirmCallback();
                    }
                    this.showModal = false;
                }
            }
        }

        function answerForm() {
            return {
                selectedAnswer: @json($currentAnswer?->selected_choice_id ?? null),
                selectAnswer(choiceId) {
                    this.selectedAnswer = choiceId;
                }
            }
        }

        function audioPlayer() {
            return {
                isPlaying: false,
                progress: 0,
                currentTime: '00:00',
                
                init() {
                    const audio = this.$refs.audio;
                    
                    audio.addEventListener('loadedmetadata', () => {
                        this.currentTime = this.formatTime(0);
                    });
                    
                    audio.addEventListener('timeupdate', () => {
                        if (audio.duration) {
                            this.progress = (audio.currentTime / audio.duration) * 100;
                            this.currentTime = this.formatTime(audio.currentTime);
                        }
                    });
                    
                    audio.addEventListener('ended', () => {
                        this.isPlaying = false;
                        this.progress = 0;
                    });
                },
                
                togglePlay() {
                    const audio = this.$refs.audio;
                    if (this.isPlaying) {
                        audio.pause();
                    } else {
                        audio.play();
                    }
                    this.isPlaying = !this.isPlaying;
                },
                
                formatTime(seconds) {
                    const min = Math.floor(seconds / 60);
                    const sec = Math.floor(seconds % 60);
                    return `${min.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;
                }
            }
        }

        // Timer Logic
        const timerElement = document.getElementById('timer');
        const endTime = new Date("{{ $endTime->toIso8601String() }}").getTime();
        
        function updateProgress() {
            const totalQuestions = {{ $allQuestions->count() }};
            const answeredQuestions = {{ count($answeredQuestionIds) }};
            const progressPercent = totalQuestions > 0 ? (answeredQuestions / totalQuestions) * 100 : 0;
            
            const mainProgressBar = document.getElementById('main-progress-bar');
            if (mainProgressBar) {
                mainProgressBar.style.width = progressPercent + '%';
            }
        }
        
        document.addEventListener('DOMContentLoaded', updateProgress);
    
        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime - now;
    
            if (distance < 0) {
                clearInterval(timerInterval);
                timerElement.innerHTML = "HABIS";
                
                // Langsung submit tanpa konfirmasi
                showToast('Waktu pengerjaan telah habis! Tes diselesaikan otomatis.', 'warning');
                setTimeout(() => {
                    document.getElementById('finish-test-form').submit();
                }, 2000);
                return;
            }
    
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
            const displayHours = String(hours).padStart(2, '0');
            const displayMinutes = String(minutes).padStart(2, '0');
            const displaySeconds = String(seconds).padStart(2, '0');
    
            if (hours > 0) {
                timerElement.innerHTML = `${displayHours}:${displayMinutes}:${displaySeconds}`;
            } else {
                timerElement.innerHTML = `${displayMinutes}:${displaySeconds}`;
            }
        }, 1000);

        // Initialize selected answer if exists
        document.addEventListener('DOMContentLoaded', function() {
            @if ($currentAnswer)
                const selectedInput = document.querySelector('input[value="{{ $currentAnswer->selected_choice_id }}"]');
                if (selectedInput) {
                    selectedInput.checked = true;
                }
            @endif
        });
    </script>
</x-layout>