<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Halaman -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manajemen Teks Bacaan</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola semua teks bacaan untuk soal Reading.</p>
            </div>
            <a href="{{ route('manajemen-reading.create') }}"
                class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
                Tambah Teks Baru
            </a>
        </div>

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Daftar Teks Bacaan -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Judul Teks</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Paket Tes</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Potongan Teks</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse($passages as $index => $passage)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $passages->firstItem() + $index }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $passage->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $passage->testPackage->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-screen-w-sm truncate"
                                    title="{{ $passage->passage_text }}">{{ Str::limit($passage->passage_text, 80) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('manajemen-reading.show', $passage) }}"
                                            class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Lihat</a>
                                        <a href="{{ route('manajemen-reading.edit', $passage) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Edit</a>
                                        <form action="{{ route('manajemen-reading.destroy', $passage) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus teks ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum
                                    ada teks bacaan yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginasi -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                {{ $passages->links() }}
            </div>
        </div>
    </div>
</x-layout>
