<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-screen-w-3xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tambah Teks Bacaan Baru</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Buat teks baru untuk digunakan di soal Reading.</p>
                </div>
                <a href="{{ route('manajemen-reading.index') }}"
                    class="text-gray-600 hover:text-gray-800 dark:text-gray-400">← Kembali</a>
            </div>

            <form action="{{ route('manajemen-reading.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 space-y-6">
                    <!-- Paket Tes -->
                    <div>
                        <label for="test_package_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Paket Tes <span
                                class="text-red-500">*</span></label>
                        <select name="test_package_id" id="test_package_id" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Pilih Paket Tes</option>
                            @foreach ($testPackages as $package)
                                <option value="{{ $package->id }}"
                                    {{ old('test_package_id') == $package->id ? 'selected' : '' }}>{{ $package->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('test_package_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Judul Teks -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul
                            Teks <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            placeholder="Contoh: Sejarah Perkembangan Internet"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Isi Teks Bacaan -->
                    <div>
                        <label for="passage_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi
                            Teks Bacaan (Passage) <span class="text-red-500">*</span></label>
                        <textarea name="passage_text" id="passage_text" rows="12" required
                            placeholder="Tempelkan atau ketik teks bacaan lengkap di sini..."
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white resize-y">{{ old('passage_text') }}</textarea>
                        @error('passage_text')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('manajemen-reading.index') }}"
                            class="px-6 py-2 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">Batal</a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">Simpan
                            Teks</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
