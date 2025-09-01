<x-layout>
    <div class="container mx-auto p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Peserta</h1>
            <p class="text-gray-600 mt-2">Kelola dan pantau aktivitas peserta ujian</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            {{-- Total Peserta --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600"><svg class="w-6 h-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg></div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Peserta</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['totalUsers'] }}</p>
                    </div>
                </div>
            </div>
            {{-- Peserta Aktif --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600"><svg class="w-6 h-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg></div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Peserta Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['activeUsersCount'] }}</p>
                    </div>
                </div>
            </div>
            {{-- Menunggu Akun --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600"><svg class="w-6 h-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg></div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Menunggu Akun</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['pendingUsersCount'] }}</p>
                    </div>
                </div>
            </div>
            {{-- Permintaan Ulang --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600"><svg class="w-6 h-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h5M7 7l10 10M17 17v-5h-5"></path>
                        </svg></div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Permintaan Ulang</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['pendingRetakeCount'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6" x-data="{ activeTab: '{{ request()->get('tab', 'all') }}' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="{{ route('manajemen-user.index') }}"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'all', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'all' }"
                        class="py-2 px-1 border-b-2 font-medium text-sm">Semua Peserta</a>
                    <a href="{{ route('manajemen-user.index', ['tab' => 'active']) }}"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'active', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'active' }"
                        class="py-2 px-1 border-b-2 font-medium text-sm">Peserta Aktif</a>
                    <a href="{{ route('manajemen-user.index', ['tab' => 'pending']) }}"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'pending', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'pending' }"
                        class="py-2 px-1 border-b-2 font-medium text-sm">Menunggu Persetujuan</a>
                    <a href="{{ route('manajemen-user.index', ['tab' => 'retake_requests']) }}"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'retake_requests', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'retake_requests' }"
                        class="py-2 px-1 border-b-2 font-medium text-sm">Permintaan Ujian Ulang</a>
                </nav>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                @if (request()->get('tab') === 'retake_requests')

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Peserta</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paket Ujian</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Permintaan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($retakeRequests as $retake)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <span
                                                        class="text-white font-medium text-sm">{{ strtoupper(substr($retake->user->name, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $retake->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $retake->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $retake->testPackage->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $retake->retake_requested_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('manajemen-user.approve_retake', $retake) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700 transition-colors"
                                                onclick="return confirm('Apakah Anda yakin ingin menyetujui permintaan ujian ulang ini?')">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Setujui
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada
                                        permintaan ujian ulang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Peserta</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Daftar</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <span
                                                        class="text-white font-medium text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->is_active)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu
                                                Persetujuan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-4">
                                            @if (!$user->is_active)
                                                <form action="{{ route('manajemen-user.approve', $user) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900"
                                                        onclick="return confirm('Anda yakin ingin menyetujui akun peserta ini?')">Setujui</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('manajemen-user.show', $user) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                            <form action="{{ route('manajemen-user.destroy', $user) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('PERINGATAN: Menghapus peserta juga akan menghapus semua riwayat ujiannya. Anda yakin?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada data
                                        peserta yang cocok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="mt-6">
            @if (isset($retakeRequests) && $retakeRequests->hasPages())
                {{ $retakeRequests->withQueryString()->links() }}
            @elseif (isset($users) && $users->hasPages())
                {{ $users->withQueryString()->links() }}
            @endif
        </div>
    </div>
</x-layout>
