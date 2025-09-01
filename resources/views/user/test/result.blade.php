<x-layout>
    <div class="container mx-auto p-6 min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full  text-center">

            <h1 class="text-3xl font-bold mb-2">Hasil Tes: {{ $session->testPackage->title }}</h1>
            <p class="text-gray-600 mb-6">Diselesaikan pada:
                {{ optional($session->end_time)->format('d F Y, H:i') ?? 'Tes belum diselesaikan' }}
            </p>

            {{-- Bungkus semua bagian yang butuh $session->result dengan @if --}}
            @if ($session->result)

                {{-- Bagian Status Lulus/Tidak Lulus --}}
                @if ($session->result->status == 'LULUS')
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold text-2xl">SELAMAT! ANDA LULUS!</p>
                    </div>
                @else
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold text-2xl">MOHON MAAF, ANDA TIDAK LULUS</p>
                    </div>
                @endif

                {{-- Bagian Rincian Skor --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 my-8 text-white">
                    <div class="bg-blue-500 p-4 rounded-lg">
                        <p class="text-sm">Listening</p>
                        <p class="text-3xl font-bold">{{ $session->result->score_listening }}</p>
                    </div>
                    <div class="bg-purple-500 p-4 rounded-lg">
                        <p class="text-sm">Structure</p>
                        <p class="text-3xl font-bold">{{ $session->result->score_structure }}</p>
                    </div>
                    <div class="bg-orange-500 p-4 rounded-lg">
                        <p class="text-sm">Reading</p>
                        <p class="text-3xl font-bold">{{ $session->result->score_reading }}</p>
                    </div>
                </div>

                {{-- Bagian Skor Total --}}
                <div class="mt-8">
                    <p class="text-gray-500">Skor Minimal Kelulusan: {{ $session->testPackage->passing_score }}</p>
                    <p class="text-xl font-semibold">Skor Total Anda:</p>
                    <p class="text-5xl font-bold text-indigo-600 my-2">{{ $session->result->total_score }}</p>
                </div>
            @else
                {{-- Tampilkan pesan ini jika $session->result tidak ada --}}
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 my-8" role="alert">
                    <p class="font-bold">Hasil Belum Tersedia</p>
                    <p>Hasil tes ini belum dapat ditampilkan karena sesi belum selesai.</p>
                </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">

                {{-- Tombol Kembali ke Dashboard --}}
                <a href="{{ route('user.dashboard') }}"
                    class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-6 rounded-lg w-full sm:w-auto text-center">
                    Kembali ke Dashboard
                </a>

                {{-- BARU: Tombol Unduh Sertifikat (Hanya muncul jika LULUS) --}}
                @if ($session->result && $session->result->status == 'LULUS')
                    <a href="{{ route('certificate.download', $session->result) }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg w-full sm:w-auto text-center">
                        Unduh Sertifikat
                    </a>
                @endif

            </div>

        </div>
    </div>
</x-layout>
