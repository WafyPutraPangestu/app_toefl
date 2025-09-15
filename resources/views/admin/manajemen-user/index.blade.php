<x-layout>
    <div class="min-h-screen  px-4 py-6 lg:px-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-mobile-2xl lg:text-4xl font-bold text-primary-900 mb-2">
                        Manajemen Peserta
                    </h1>
                    <p class="text-mobile-base text-neutral-600">
                        Kelola dan pantau aktivitas peserta ujian TOEFL
                    </p>
                </div>
                
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 card-mobile border-l-4 border-accent-500 bg-accent-50 p-4 animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-accent-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-accent-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 card-mobile border-l-4 border-danger-500 bg-danger-50 p-4 animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-danger-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.232 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span class="text-danger-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6 mb-8">
            <!-- Total Peserta -->
            <div class="card-mobile-lg hover:shadow-lg transition-all duration-200 group">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-mobile-sm font-medium text-neutral-600 mb-1">Total Peserta</p>
                        <div class="flex items-baseline">
                            <p class="text-mobile-2xl font-bold text-neutral-900">{{ $stats['totalUsers'] }}</p>
                            <span class="ml-2 text-xs text-accent-600 font-medium">+12% dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peserta Aktif -->
            <div class="card-mobile-lg hover:shadow-lg transition-all duration-200 group">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-accent-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-mobile-sm font-medium text-neutral-600 mb-1">Peserta Aktif</p>
                        <div class="flex items-baseline">
                            <p class="text-mobile-2xl font-bold text-neutral-900">{{ $stats['activeUsersCount'] }}</p>
                            {{-- <span class="ml-2 text-xs text-accent-600 font-medium">{{ round(($stats['activeUsersCount']/$stats['totalUsers'])*100) }}%</span> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menunggu Persetujuan -->
            <div class="card-mobile-lg hover:shadow-lg transition-all duration-200 group">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-warning-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-mobile-sm font-medium text-neutral-600 mb-1">Menunggu Persetujuan</p>
                        <div class="flex items-baseline">
                            <p class="text-mobile-2xl font-bold text-neutral-900">{{ $stats['pendingUsersCount'] }}</p>
                            @if($stats['pendingUsersCount'] > 0)
                                <span class="ml-2 px-2 py-1 text-xs bg-warning-100 text-warning-800 rounded-full font-medium">Perlu Tindakan</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permintaan Ujian Ulang -->
            <div class="card-mobile-lg hover:shadow-lg transition-all duration-200 group">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-secondary-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M7 7l10 10M17 17v-5h-5"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-mobile-sm font-medium text-neutral-600 mb-1">Permintaan Ujian Ulang</p>
                        <div class="flex items-baseline">
                            <p class="text-mobile-2xl font-bold text-neutral-900">{{ $stats['pendingRetakeCount'] }}</p>
                            @if($stats['pendingRetakeCount'] > 0)
                                <span class="ml-2 px-2 py-1 text-xs bg-secondary-100 text-secondary-800 rounded-full font-medium">Review</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="mb-6" x-data="{ activeTab: '{{ request()->get('tab', 'all') }}' }">
            <div class="card-mobile overflow-hidden">
                <nav class="flex flex-wrap">
                    <a href="{{ route('manajemen-user.index') }}" 
                       :class="{ 'bg-primary-50 border-primary-500 text-primary-700': activeTab === 'all', 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50': activeTab !== 'all' }" 
                       class="flex-1 md:flex-none px-4 py-3 text-mobile-sm font-medium border-b-2 border-transparent transition-all duration-200 text-center md:text-left min-w-max">
                        <span class="flex items-center justify-center md:justify-start">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Semua Peserta
                        </span>
                    </a>
                    <a href="{{ route('manajemen-user.index', ['tab' => 'active']) }}" 
                       :class="{ 'bg-primary-50 border-primary-500 text-primary-700': activeTab === 'active', 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50': activeTab !== 'active' }" 
                       class="flex-1 md:flex-none px-4 py-3 text-mobile-sm font-medium border-b-2 border-transparent transition-all duration-200 text-center md:text-left min-w-max">
                        <span class="flex items-center justify-center md:justify-start">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Peserta Aktif
                        </span>
                    </a>
                    <a href="{{ route('manajemen-user.index', ['tab' => 'pending']) }}" 
                       :class="{ 'bg-primary-50 border-primary-500 text-primary-700': activeTab === 'pending', 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50': activeTab !== 'pending' }" 
                       class="flex-1 md:flex-none px-4 py-3 text-mobile-sm font-medium border-b-2 border-transparent transition-all duration-200 text-center md:text-left min-w-max">
                        <span class="flex items-center justify-center md:justify-start">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Menunggu Persetujuan
                            @if($stats['pendingUsersCount'] > 0)
                                <span class="ml-2 px-2 py-1 text-xs bg-warning-500 text-white rounded-full">{{ $stats['pendingUsersCount'] }}</span>
                            @endif
                        </span>
                    </a>
                    <a href="{{ route('manajemen-user.index', ['tab' => 'retake_requests']) }}" 
                       :class="{ 'bg-primary-50 border-primary-500 text-primary-700': activeTab === 'retake_requests', 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50': activeTab !== 'retake_requests' }" 
                       class="flex-1 md:flex-none px-4 py-3 text-mobile-sm font-medium border-b-2 border-transparent transition-all duration-200 text-center md:text-left min-w-max">
                        <span class="flex items-center justify-center md:justify-start">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M7 7l10 10M17 17v-5h-5"></path>
                            </svg>
                            Ujian Ulang
                            @if($stats['pendingRetakeCount'] > 0)
                                <span class="ml-2 px-2 py-1 text-xs bg-secondary-500 text-white rounded-full">{{ $stats['pendingRetakeCount'] }}</span>
                            @endif
                        </span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card-mobile-lg overflow-hidden">
            <div class="overflow-x-auto">
                @if (request()->get('tab') === 'retake_requests')
                    <!-- Retake Requests Table -->
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Peserta</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Paket Ujian</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Tanggal Permintaan</th>
                                <th class="px-6 py-4 text-right flex text-xs font-semibold text-neutral-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-100">
                            @forelse ($retakeRequests as $retake)
                                <tr class="hover:bg-neutral-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-full gradient-primary flex items-center justify-center shadow-sm">
                                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($retake->user->name, 0, 2)) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-mobile-sm font-semibold text-neutral-900">{{ $retake->user->name }}</div>
                                                <div class="text-mobile-xs text-neutral-600">{{ $retake->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-mobile-sm font-medium text-neutral-900">{{ $retake->testPackage->title }}</div>
                                        <div class="text-mobile-xs text-neutral-600">Paket TOEFL</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-mobile-sm text-neutral-900">{{ $retake->retake_requested_at->format('d M Y') }}</div>
                                        <div class="text-mobile-xs text-neutral-600">{{ $retake->retake_requested_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('manajemen-user.approve_retake', $retake) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn-mobile flex  bg-accent-600 text-white hover:bg-accent-700 focus:ring-2 focus:ring-accent-500 focus:ring-offset-2"
                                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui permintaan ujian ulang ini?')">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Setujui
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-neutral-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-neutral-500 text-mobile-base">Tidak ada permintaan ujian ulang saat ini</p>
                                            <p class="text-neutral-400 text-mobile-sm mt-1">Permintaan baru akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                    <!-- Regular Users Table -->
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Peserta</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-right text-xs flex justify-center font-semibold text-neutral-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-100">
                            @forelse ($users as $user)
                                <tr class="hover:bg-neutral-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-full gradient-primary flex items-center justify-center shadow-sm">
                                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-mobile-sm font-semibold text-neutral-900">{{ $user->name }}</div>
                                                <div class="text-mobile-xs text-neutral-600">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($user->is_active)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent-100 text-accent-800">
                                                <div class="w-2 h-2 bg-accent-500 rounded-full mr-2"></div>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-warning-100 text-warning-800">
                                                <div class="w-2 h-2 bg-warning-500 rounded-full mr-2"></div>
                                                Menunggu Persetujuan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-mobile-sm text-neutral-900">{{ $user->created_at->format('d M Y') }}</div>
                                        <div class="text-mobile-xs text-neutral-600">{{ $user->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if (!$user->is_active)
                                                <form action="{{ route('manajemen-user.approve', $user) }}" method="POST" class="inline ">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn-mobile bg-accent-600 text-white hover:bg-accent-700 focus:ring-2 focus:ring-accent-500 focus:ring-offset-2"
                                                            onclick="return confirm('Anda yakin ingin menyetujui akun peserta ini?')">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Setujui
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('manajemen-user.show', $user) }}" 
                                               class="btn-mobile flex bg-primary-600 text-white hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Detail
                                            </a>
                                            <form action="{{ route('manajemen-user.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn-mobile flex bg-danger-600 text-white hover:bg-danger-700 focus:ring-2 focus:ring-danger-500 focus:ring-offset-2"
                                                        onclick="return confirm('PERINGATAN: Menghapus peserta juga akan menghapus semua riwayat ujiannya. Anda yakin?')">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-neutral-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            <p class="text-neutral-500 text-mobile-base">Tidak ada data peserta yang cocok</p>
                                            <p class="text-neutral-400 text-mobile-sm mt-1">Coba ubah filter atau tambah peserta baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if ((isset($retakeRequests) && $retakeRequests->hasPages()) || (isset($users) && $users->hasPages()))
            <div class="mt-6 flex justify-center">
                <div class="card-mobile inline-block">
                    @if (isset($retakeRequests) && $retakeRequests->hasPages())
                        {{ $retakeRequests->withQueryString()->links() }}
                    @elseif (isset($users) && $users->hasPages())
                        {{ $users->withQueryString()->links() }}
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-layout>