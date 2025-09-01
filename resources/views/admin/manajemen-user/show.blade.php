<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Halaman dan Tombol Kembali -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Peserta</h1>
                <p class="text-gray-500">Melihat profil dan riwayat ujian peserta.</p>
            </div>
            <a href="{{ route('manajemen-user.index') }}"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                &larr; Kembali ke Daftar Peserta
            </a>
        </div>

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Kartu Informasi Profil Pengguna -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Profil</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Alamat Email</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $user->created_at->format('d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status Akun</dt>
                    <dd class="mt-1">
                        @if ($user->is_active)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Menunggu Persetujuan
                            </span>
                        @endif
                    </dd>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Ujian -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-700">Riwayat Ujian</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket Tes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Kelulusan
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi Ujian
                                Ulang</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($user->testSessions as $session)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                                    {{ $session->testPackage->title ?? 'Paket Dihapus' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    {{ $session->end_time ? $session->end_time->format('d M Y, H:i') : 'Dalam Proses' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-lg text-gray-800">
                                    {{ $session->result->total_score ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (isset($session->result->status))
                                        @if ($session->result->status == 'LULUS')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                LULUS
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                TIDAK LULUS
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    @if ($session->status == 'completed')
                                        <!-- HANYA TAMPILKAN TOMBOL JIKA ADA PERMINTAAN DARI PESERTA -->
                                        @if ($session->retake_requested_at)
                                            <form action="{{ route('manajemen-user.reset_test', $session) }}"
                                                method="POST"
                                                onsubmit="return confirm('Setujui permintaan ujian ulang untuk peserta ini? Riwayat lama akan dihapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-900 font-semibold">
                                                    Setujui Ulang
                                                </button>
                                            </form>
                                        @else
                                            <!-- Jika tidak ada permintaan, tampilkan status -->
                                            <span class="text-gray-400 italic">Tidak ada permintaan</span>
                                        @endif
                                    @else
                                        <span class="text-yellow-600 italic">Dalam Proses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Pengguna ini belum pernah mengerjakan ujian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
