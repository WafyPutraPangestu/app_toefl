<x-layout>
    <div x-data="{ 
        notifications: [],
        addNotification(type, message) {
            const id = Date.now();
            this.notifications.push({ id, type, message });
            setTimeout(() => this.removeNotification(id), 5000);
        },
        removeNotification(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }" 
    @notification.window="addNotification($event.detail.type, $event.detail.message)"
    class="fixed top-4 right-4 z-50 space-y-2 w-full max-w-xs sm:max-w-sm">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-show="true" 
                 x-transition:enter="transform ease-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-full bg-white rounded-lg shadow-lg border-l-4"
                 :class="{
                   'border-green-500': notification.type === 'success',
                   'border-red-500': notification.type === 'error',
                   'border-yellow-500': notification.type === 'warning',
                   'border-blue-500': notification.type === 'info'
                 }">
                <div class="p-4 flex items-start">
                    <div class="flex-shrink-0 mr-3">
                        <template x-if="notification.type === 'success'">
                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </template>
                        <template x-if="notification.type === 'error'">
                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        </template>
                        <template x-if="notification.type === 'warning'">
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </template>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900" x-text="notification.message"></p>
                    </div>
                    <button @click="removeNotification(notification.id)" class="ml-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div class="min-h-screen bg-gray-50">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg">
            <div class="px-4 sm:px-6 lg:px-8 py-8 md:py-12">
                <h1 class="text-3xl md:text-4xl font-bold text-center">Dashboard Peserta</h1>
                <p class="text-center opacity-90 mt-2">Kelola tes TOEFL Anda dengan mudah</p>
            </div>
        </div>

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.dispatchEvent(new CustomEvent('notification', { detail: { type: 'success', message: '{{ session('success') }}' }}));
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.dispatchEvent(new CustomEvent('notification', { detail: { type: 'error', message: '{{ session('error') }}' }}));
                });
            </script>
        @endif

        <div class="px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    // PHP logic remains the same
                    $availableTests = collect();
                    $completedTests = collect();
                    $failedTests = collect();
                    foreach($testPackages as $package) {
                        $sessionsForPackage = $testHistory->where('test_package_id', $package->id);
                        $inProgressSession = $sessionsForPackage->firstWhere('status', 'in_progress');
                        $lulusSession = $sessionsForPackage->firstWhere('result.status', 'LULUS');
                        $latestCompletedSession = $sessionsForPackage->where('status', 'completed')->first();
                        if ($lulusSession) {
                            $completedTests->push((object)['package' => $package, 'session' => $lulusSession, 'status' => 'lulus']);
                        } elseif ($latestCompletedSession && optional($latestCompletedSession->result)->status == 'TIDAK LULUS') {
                            $failedTests->push((object)['package' => $package, 'session' => $latestCompletedSession, 'status' => 'tidak_lulus']);
                        } elseif ($inProgressSession) {
                            $availableTests->push((object)['package' => $package, 'session' => $inProgressSession, 'status' => 'in_progress']);
                        } else {
                            $availableTests->push((object)['package' => $package, 'session' => null, 'status' => 'available']);
                        }
                    }
                @endphp

                <div class="bg-white rounded-xl shadow-md border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Tes Tersedia</h3>
                                <p class="text-sm text-gray-600">Siap untuk dikerjakan</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-bold text-blue-600">{{ $availableTests->count() }}</span>
                            @if($availableTests->count() > 0)
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-blue-200 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                                        <span>Lihat Detail</span>
                                        <svg class="ml-2 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-transition @click.outside="open = false" class="absolute right-0 top-12 w-72 md:w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-30">
                                        <div class="p-4">
                                            <h4 class="font-semibold text-gray-900 mb-3">Tes yang Dapat Dikerjakan</h4>
                                            <div class="space-y-3 max-h-60 overflow-y-auto">
                                                @foreach($availableTests as $item)
                                                    <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-1">
                                                                <h5 class="font-medium text-gray-900 text-sm">{{ $item->package->title }}</h5>
                                                                <p class="text-xs text-gray-600 mt-1">{{ $item->package->questions_count }} soal • {{ $item->package->duration_minutes }} menit</p>
                                                                @if($item->status == 'in_progress')
                                                                    <span class="inline-block mt-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Sedang Dikerjakan</span>
                                                                @endif
                                                            </div>
                                                            <div class="ml-3">
                                                                @if($item->status == 'in_progress')
                                                                    <a href="{{ route('user.test.show', ['session' => $item->session->id, 'question' => $item->session->testPackage->questions()->first()->id]) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs rounded-lg hover:bg-yellow-600 transition-colors">Lanjutkan</a>
                                                                @else
                                                                    <form action="{{ route('user.test.start', $item->package) }}" method="POST" class="inline"> @csrf <button type="submit" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition-colors">Mulai</button></form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Tes Lulus</h3>
                                <p class="text-sm text-gray-600">Berhasil diselesaikan</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-bold text-green-600">{{ $completedTests->count() }}</span>
                            @if($completedTests->count() > 0)
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-green-200 rounded-lg text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 transition-colors">
                                        <span>Lihat Detail</span>
                                        <svg class="ml-2 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-transition @click.outside="open = false" class="absolute right-0 top-12 w-72 md:w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-30">
                                        <div class="p-4">
                                            <h4 class="font-semibold text-gray-900 mb-3">Tes yang Telah Lulus</h4>
                                            <div class="space-y-3 max-h-60 overflow-y-auto">
                                                @foreach($completedTests as $item)
                                                    <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-1"><h5 class="font-medium text-gray-900 text-sm">{{ $item->package->title }}</h5><p class="text-xs text-gray-600 mt-1">Skor: {{ optional($item->session->result)->total_score }} • {{ optional($item->session->end_time)->format('d M Y') }}</p><span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Lulus</span></div>
                                                            <div class="ml-3"><a href="{{ route('user.test.result', $item->session) }}" class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs rounded-lg hover:bg-green-600 transition-colors">Lihat</a></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Tes Gagal</h3>
                                <p class="text-sm text-gray-600">Perlu pengerjaan ulang</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-bold text-red-600">{{ $failedTests->count() }}</span>
                            @if($failedTests->count() > 0)
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-red-200 rounded-lg text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                                        <span>Lihat Detail</span>
                                        <svg class="ml-2 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-transition @click.outside="open = false" class="absolute right-0 top-12 w-72 md:w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-30">
                                        <div class="p-4">
                                            <h4 class="font-semibold text-gray-900 mb-3">Tes yang Gagal</h4>
                                            <div class="space-y-3 max-h-60 overflow-y-auto">
                                                @foreach($failedTests as $item)
                                                    <div class="p-3 border border-gray-100 rounded-lg hover:bg-gray-50">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-1"><h5 class="font-medium text-gray-900 text-sm">{{ $item->package->title }}</h5><p class="text-xs text-gray-600 mt-1">Skor: {{ optional($item->session->result)->total_score }} • {{ optional($item->session->end_time)->format('d M Y') }}</p><span class="inline-block mt-2 px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Tidak Lulus</span></div>
                                                            <div class="ml-3 flex flex-col space-y-1">
                                                                @if ($item->session->retake_approved_at)
                                                                    <form action="{{ route('user.test.start', $item->package) }}" method="POST" class="inline">@csrf<button type="submit" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition-colors">Ulang</button></form>
                                                                @elseif ($item->session->retake_requested_at)
                                                                    <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-lg">Menunggu</span>
                                                                @else
                                                                    <form action="{{ route('user.test.requestRetake', $item->session) }}" method="POST" class="inline">@csrf<button type="submit" class="inline-flex items-center px-3 py-1 bg-orange-500 text-white text-xs rounded-lg hover:bg-orange-600 transition-colors">Ajukan</button></form>
                                                                @endif
                                                                <a href="{{ route('user.test.result', $item->session) }}" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-xs rounded-lg hover:bg-gray-600 transition-colors">Lihat</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                @php
                    $passedHistory = $testHistory->filter(fn($history) => optional($history->result)->status == 'LULUS')->sortByDesc('created_at');
                    $failedHistory = $testHistory->filter(fn($history) => optional($history->result)->status == 'TIDAK LULUS')->sortByDesc('created_at');
                @endphp

                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3"><div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center"><svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div><div><h2 class="text-lg font-bold text-gray-900">Riwayat Tes Berhasil</h2><p class="text-sm text-gray-600">{{ $passedHistory->count() }} tes telah lulus</p></div></div>
                            @if($passedHistory->count() > 0)
                                <div x-data="{ open: false }">
                                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-green-200 rounded-lg text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 transition-colors"><span x-text="open ? 'Tutup' : 'Lihat Semua'"></span><svg class="ml-2 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                                    <div x-show="open" x-collapse class="mt-4">
                                        <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                            @foreach($passedHistory as $history)
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 py-3 px-4 bg-green-50 rounded-lg border border-green-100">
                                                    <div class="flex items-center space-x-3 flex-1">
                                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></div>
                                                        <div class="flex-1 min-w-0"><h4 class="text-sm font-semibold text-gray-900">{{ $history->testPackage->title }}</h4><div class="flex items-center flex-wrap gap-x-2 mt-1"><span class="text-xs text-gray-500">{{ optional($history->end_time)->format('d M Y, H:i') }}</span>@if (optional($history->result)->total_score)<span class="text-xs font-medium text-green-700">Skor: {{ $history->result->total_score }}</span>@endif</div></div>
                                                    </div>
                                                    <div class="flex items-center space-x-2 self-end sm:self-center">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Lulus</span>
                                                        <a href="{{ route('user.test.result', $history) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if($passedHistory->count() == 0)
                        <div class="p-8 text-center"><div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div><h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Tes yang Lulus</h3><p class="text-gray-600 mb-4">Anda belum memiliki tes yang berhasil diselesaikan</p><p class="text-sm text-gray-500">Kerjakan tes yang tersedia untuk mencapai target lulus</p></div>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3"><div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center"><svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg></div><div><h2 class="text-lg font-bold text-gray-900">Riwayat Tes Gagal</h2><p class="text-sm text-gray-600">{{ $failedHistory->count() }} tes perlu diperbaiki</p></div></div>
                            @if($failedHistory->count() > 0)
                                <div x-data="{ open: false }">
                                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-red-200 rounded-lg text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition-colors"><span x-text="open ? 'Tutup' : 'Lihat Semua'"></span><svg class="ml-2 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                                    <div x-show="open" x-collapse class="mt-4">
                                        <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                            @foreach($failedHistory as $history)
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 py-3 px-4 bg-red-50 rounded-lg border border-red-100">
                                                    <div class="flex items-center space-x-3 flex-1">
                                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg></div>
                                                        <div class="flex-1 min-w-0"><h4 class="text-sm font-semibold text-gray-900">{{ $history->testPackage->title }}</h4><div class="flex items-center flex-wrap gap-x-2 mt-1"><span class="text-xs text-gray-500">{{ optional($history->end_time)->format('d M Y, H:i') }}</span>@if (optional($history->result)->total_score)<span class="text-xs font-medium text-red-700">Skor: {{ $history->result->total_score }}</span>@endif</div></div>
                                                    </div>
                                                    <div class="flex items-center space-x-2 self-end sm:self-center">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Gagal</span>
                                                        <a href="{{ route('user.test.result', $history) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors" title="Lihat Hasil"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if($failedHistory->count() == 0)
                        <div class="p-8 text-center"><div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg></div><h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Tes yang Gagal</h3><p class="text-gray-600 mb-4">Selamat! Semua tes Anda berhasil atau belum dikerjakan</p><p class="text-sm text-gray-500">Terus pertahankan performa yang baik</p></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="pb-8"></div>
    </div>

    <style>
        * { transition: all 0.2s ease; }
        .overflow-y-auto::-webkit-scrollbar { width: 6px; }
        .overflow-y-auto::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
        .overflow-y-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .overflow-y-auto::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        button:focus, a:focus { outline: 2px solid #3b82f6; outline-offset: 2px; }
        .bg-white:hover { box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .loading { opacity: 0.6; pointer-events: none; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const button = form.querySelector('button[type="submit"]');
                    if (button) {
                        button.disabled = true; button.classList.add('loading');
                        const originalText = button.innerHTML;
                        button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
                        setTimeout(() => { button.disabled = false; button.classList.remove('loading'); button.innerHTML = originalText; }, 3000);
                    }
                });
            });
        });
    </script>
</x-layout>