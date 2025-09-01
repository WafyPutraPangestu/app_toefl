<x-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Dashboard Peserta</h1>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Daftar Paket Tes --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4">Paket Tes Tersedia</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($testPackages as $package)
                    <div class="border rounded-lg p-4 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold">{{ $package->title }}</h3>
                            <p class="text-gray-600 mt-2">{{ $package->description }}</p>
                            <ul class="text-sm text-gray-500 mt-3 list-disc list-inside">
                                <li>Jumlah Soal: {{ $package->questions_count }}</li>
                                <li>Durasi: {{ $package->duration_minutes }} menit</li>
                                <li>Skor Lulus: {{ $package->passing_score }}</li>
                            </ul>
                        </div>

                        {{-- BLOK LOGIKA FINAL UNTUK TOMBOL AKSI --}}
                        <div class="mt-4">
                            @php
                                $sessionsForPackage = $testHistory->where('test_package_id', $package->id);

                                $inProgressSession = $sessionsForPackage->firstWhere('status', 'in_progress');
                                $lulusSession = $sessionsForPackage->firstWhere('result.status', 'LULUS');
                                $latestCompletedSession = $sessionsForPackage->where('status', 'completed')->first();
                            @endphp

                            {{-- PRIORITAS 1: Jika ada tes yang sedang berjalan --}}
                            @if ($inProgressSession)
                                <a href="{{ route('user.test.show', ['session' => $inProgressSession->id, 'question' => $inProgressSession->testPackage->questions()->first()->id]) }}"
                                    class="w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                                    Lanjutkan Pengerjaan
                                </a>

                                {{-- PRIORITAS 2: Jika pernah lulus --}}
                            @elseif ($lulusSession)
                                <a href="{{ route('user.test.result', $lulusSession) }}"
                                    class="w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                    ✅ Lulus (Lihat Hasil)
                                </a>

                                {{-- PRIORITAS 3: Jika sesi terakhir selesai dan hasilnya GAGAL --}}
                            @elseif ($latestCompletedSession && optional($latestCompletedSession->result)->status == 'TIDAK LULUS')
                                {{-- SUDAH DISETUJUI? --}}
                                @if ($latestCompletedSession->retake_approved_at)
                                    <form action="{{ route('user.test.start', $package) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Kerjakan Ulang (Disetujui)
                                        </button>
                                    </form>

                                    {{-- SUDAH MENGAJUKAN TAPI BELUM DISETUJUI? --}}
                                @elseif ($latestCompletedSession->retake_requested_at)
                                    <button
                                        class="w-full bg-gray-400 text-white font-bold py-2 px-4 rounded cursor-not-allowed"
                                        disabled>
                                        Menunggu Persetujuan
                                    </button>

                                    {{-- BELUM MENGAJUKAN SAMA SEKALI? --}}
                                @else
                                    <form action="{{ route('user.test.requestRetake', $latestCompletedSession) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                            Ajukan Pengerjaan Ulang
                                        </button>
                                    </form>
                                @endif

                                {{-- PRIORITAS 4: Jika belum pernah mengerjakan sama sekali --}}
                            @else
                                <form action="{{ route('user.test.start', $package) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                        Mulai Tes
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @empty
                    <p>Belum ada paket tes yang tersedia.</p>
                @endforelse
            </div>
        </div>

        {{-- Riwayat Pengerjaan --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Riwayat Tes Anda</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Paket Tes</th>
                            <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Selesai</th>
                            <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Skor Total</th>
                            <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($testHistory as $history)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $history->testPackage->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ optional($history->end_time)->format('d M Y, H:i') ?? 'Belum Selesai' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ optional($history->result)->total_score ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $status = optional($history->result)->status;
                                    @endphp
                                    @if ($status == 'LULUS')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">LULUS</span>
                                    @elseif ($status == 'TIDAK LULUS')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">TIDAK
                                            LULUS</span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Sedang
                                            Dikerjakan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($history->status == 'completed')
                                        <a href="{{ route('user.test.result', $history) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Anda belum memiliki riwayat pengerjaan tes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
