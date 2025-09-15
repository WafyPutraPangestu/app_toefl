<x-layout>
    <div class="min-h-screen bg-neutral-50">
        <!-- Header Container dengan design yang lebih subtle -->
        <div class="bg-white border-b border-neutral-200 pb-8 pt-8">
            <div class=" mx-auto px-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="animate-fade-in">
                        <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-2">
                            Manajemen Teks Bacaan
                        </h1>
                        <p class="text-neutral-600 text-lg">
                            Kelola semua teks bacaan untuk soal Reading dengan mudah
                        </p>
                    </div>
                    <div class="mt-6 md:mt-0 animate-slide-up">
                        <a href="{{ route('manajemen-reading.create') }}"
                            class="btn-mobile-lg bg-neutral-900 text-white hover:bg-neutral-800 
                                   shadow-sm hover:shadow-md transform hover:scale-105 inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Teks Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class=" mx-auto px-4 py-8">
            <!-- Success Notification dengan design minimal -->
            @if (session('success'))
                <div class="card-mobile-lg mb-6 border-l-4 border-neutral-400 bg-neutral-100 animate-bounce-in">
                    <div class="flex items-center p-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-neutral-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-neutral-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards dengan warna netral -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card-mobile-lg p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 bg-white border border-neutral-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-600 text-sm font-medium">Total Teks</p>
                            <p class="text-neutral-900 text-2xl font-bold">{{ $passages->total() }}</p>
                        </div>
                        <div class="p-3 bg-neutral-100 rounded-full">
                            <svg class="w-6 h-6 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="card-mobile-lg p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 bg-white border border-neutral-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-600 text-sm font-medium">Halaman Ini</p>
                            <p class="text-neutral-900 text-2xl font-bold">{{ $passages->count() }}</p>
                        </div>
                        <div class="p-3 bg-neutral-100 rounded-full">
                            <svg class="w-6 h-6 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="card-mobile-lg p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 bg-white border border-neutral-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-600 text-sm font-medium">Per Halaman</p>
                            <p class="text-neutral-900 text-2xl font-bold">{{ $passages->perPage() }}</p>
                        </div>
                        <div class="p-3 bg-neutral-100 rounded-full">
                            <svg class="w-6 h-6 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Table Card -->
            <div class="card-mobile-lg overflow-hidden bg-white border border-neutral-200">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-neutral-200 bg-neutral-50">
                    <h3 class="text-lg font-semibold text-neutral-900">Daftar Teks Bacaan</h3>
                </div>

                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-100 border-b border-neutral-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Judul Teks</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Paket Tes</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Potongan Teks</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-neutral-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @forelse($passages as $index => $passage)
                                <tr class="hover:bg-neutral-50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-neutral-200 text-neutral-800 rounded-full text-sm font-medium">
                                            {{ $passages->firstItem() + $index }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-neutral-900 group-hover:text-neutral-700 transition-colors">
                                            {{ $passage->title }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-neutral-200 text-neutral-800">
                                            {{ $passage->testPackage->title ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 max-w-xs">
                                        <p class="text-sm text-neutral-600 truncate" title="{{ $passage->passage_text }}">
                                            {{ Str::limit($passage->passage_text, 80) }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('manajemen-reading.show', $passage) }}"
                                                class="btn-mobile flex  bg-neutral-100 text-neutral-700 hover:bg-neutral-200 border border-neutral-300">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Lihat
                                            </a>
                                            <a href="{{ route('manajemen-reading.edit', $passage) }}"
                                                class="btn-mobile flex bg-green-600 text-white hover:bg-green-800 border border-neutral-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('manajemen-reading.destroy', $passage) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus teks ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn-mobile flex bg-red-600 cursor-pointer text-white hover:bg-red-800 border border-neutral-600">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-neutral-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <h3 class="text-lg font-medium text-neutral-600 mb-2">Belum ada teks bacaan</h3>
                                            <p class="text-neutral-500 mb-6">Mulai dengan menambahkan teks bacaan pertama Anda</p>
                                            <a href="{{ route('manajemen-reading.create') }}" 
                                               class="btn-mobile-lg bg-neutral-900 text-white hover:bg-neutral-800">
                                                Tambah Teks Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="lg:hidden">
                    @forelse($passages as $index => $passage)
                        <div class="p-4 border-b border-neutral-200 last:border-b-0 hover:bg-neutral-50 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-neutral-200 text-neutral-800 rounded-full text-sm font-medium mr-3">
                                        {{ $passages->firstItem() + $index }}
                                    </span>
                                    <div>
                                        <h4 class="text-mobile-lg font-semibold text-neutral-900">{{ $passage->title }}</h4>
                                        <p class="text-mobile-sm text-neutral-600">{{ $passage->testPackage->title ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-mobile-sm text-neutral-600 mb-4 line-clamp-2">
                                {{ Str::limit($passage->passage_text, 120) }}
                            </p>
                            
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('manajemen-reading.show', $passage) }}"
                                    class="btn-mobile bg-neutral-100 text-neutral-700 hover:bg-neutral-200 text-mobile-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('manajemen-reading.edit', $passage) }}"
                                    class="btn-mobile bg-neutral-800 text-white hover:bg-neutral-700 text-mobile-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('manajemen-reading.destroy', $passage) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus teks ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-mobile bg-neutral-600 text-white hover:bg-neutral-700 text-mobile-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <svg class="w-16 h-16 text-neutral-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-mobile-xl font-medium text-neutral-600 mb-2">Belum ada teks bacaan</h3>
                            <p class="text-mobile-sm text-neutral-500 mb-6">Mulai dengan menambahkan teks bacaan pertama Anda</p>
                            <a href="{{ route('manajemen-reading.create') }}" 
                               class="btn-mobile-lg bg-neutral-900 text-white hover:bg-neutral-800 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Teks Baru
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($passages->hasPages())
                    <div class="px-6 py-4 border-t border-neutral-200 bg-neutral-50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="mb-4 sm:mb-0">
                                <p class="text-mobile-sm text-neutral-600">
                                    Menampilkan <span class="font-medium text-neutral-900">{{ $passages->firstItem() }}</span> 
                                    sampai <span class="font-medium text-neutral-900">{{ $passages->lastItem() }}</span> 
                                    dari <span class="font-medium text-neutral-900">{{ $passages->total() }}</span> hasil
                                </p>
                            </div>
                            <div class="pagination-wrapper">
                                {{ $passages->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Custom line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom pagination styling dengan warna netral */
        .pagination-wrapper nav {
            @apply flex items-center space-x-1;
        }
        
        .pagination-wrapper nav a,
        .pagination-wrapper nav span {
            @apply px-3 py-2 text-sm rounded-lg border transition-all duration-200;
        }
        
        .pagination-wrapper nav a {
            @apply border-neutral-300 text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 hover:border-neutral-400;
        }
        
        .pagination-wrapper nav span[aria-current="page"] {
            @apply bg-neutral-900 text-white border-neutral-900;
        }
        
        .pagination-wrapper nav span:not([aria-current]) {
            @apply border-neutral-300 text-neutral-400;
        }
    </style>
</x-layout>