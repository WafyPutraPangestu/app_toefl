<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Hasil -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Hasil Ujian TOEFL</h1>
            <!-- PERBAIKAN: Gunakan 'title' bukan 'name' -->
            <p class="text-gray-600">{{ $testSession->testPackage->title }}</p>
        </div>

        <!-- Status Kelulusan -->
        <div class="mb-8">
            @if ($testSession->result->status == 'LULUS')
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-green-800 mb-2">SELAMAT! ANDA LULUS</h2>
                    <p class="text-green-700">Anda berhasil mencapai skor minimum yang diperlukan.</p>
                </div>
            @else
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-red-800 mb-2">BELUM LULUS</h2>
                    <p class="text-red-700">Anda belum mencapai skor minimum. Tetap semangat!</p>
                </div>
            @endif
        </div>

        <!-- Detail Skor & Informasi Ujian (Sama seperti sebelumnya, tapi dengan perbaikan nama kolom) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Skor per Sesi -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Rincian Skor</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                        <span class="font-medium text-blue-800">Listening</span>
                        <span
                            class="text-2xl font-bold text-blue-600">{{ $testSession->result->score_listening }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                        <span class="font-medium text-green-800">Structure</span>
                        <span
                            class="text-2xl font-bold text-green-600">{{ $testSession->result->score_structure }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                        <span class="font-medium text-purple-800">Reading</span>
                        <span
                            class="text-2xl font-bold text-purple-600">{{ $testSession->result->score_reading }}</span>
                    </div>
                </div>
            </div>

            <!-- Skor Total -->
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-center">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Skor Total</h3>
                <div class="text-center">
                    <div class="text-6xl font-bold text-gray-800 mb-2">{{ $testSession->result->total_score }}</div>
                    <div class="text-gray-600 mb-4">dari 677 maksimal</div>
                    <div class="text-sm text-gray-500">
                        Minimum untuk lulus: {{ $testSession->testPackage->passing_score }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>

            <!-- Tombol Unduh Sertifikat hanya muncul jika LULUS -->
            @if ($testSession->result->status == 'LULUS')
                <a href="{{ route('certificate.download', $testSession->result) }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Unduh Sertifikat
                </a>
            @endif
            <!-- Tombol "Coba Lagi" sudah dihapus -->
        </div>
    </div>
</x-layout>
