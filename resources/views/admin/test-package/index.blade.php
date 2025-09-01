<x-layout>
    <!-- Toast Notifications -->
    <div x-data="{
        showSuccess: false,
        successMessage: '',
        init() {
            @if (session('success')) this.successMessage = '{{ session('success') }}';
                this.showSuccess = true;
                setTimeout(() => this.showSuccess = false, 5000); @endif
        }
    }" class="fixed top-4 right-4 z-50">
        <!-- Success Toast -->
        <div x-show="showSuccess" x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="max-w-sm w-full bg-white dark:bg-neutral-800 shadow-lg rounded-2xl pointer-events-auto ring-1 ring-black ring-opacity-5 border border-accent-200 dark:border-accent-700">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 h-8 bg-accent-100 dark:bg-accent-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-accent-600 dark:text-accent-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100" x-text="successMessage">
                        </p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="showSuccess = false"
                            class="rounded-lg inline-flex text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-accent-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-neutral-600 dark:text-neutral-400">Test Packages</h1>
                            <p class="text-neutral-600 dark:text-neutral-400">Manage and organize your TOEFL test
                                packages</p>
                        </div>
                    </div>

                    @if (!$testPackages->isEmpty())
                        <!-- Create Button -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('test-packages.create') }}"
                                class="btn-mobile-lg gradient-primary dark:gradient-red-200 text-white  focus:ring-primary-500 inline-flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Create New Package</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            @if ($testPackages->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="card-mobile-lg max-w-md mx-auto">
                        <div
                            class="w-20 h-20 bg-neutral-100 dark:bg-neutral-800 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-neutral-400 dark:text-neutral-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100 mb-2">No Test Packages
                            Yet</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-6">Get started by creating your first test
                            package to organize your TOEFL assessments.</p>

                        <a href="{{ route('test-packages.create') }}"
                            class="btn-mobile-lg gradient-primary text-white focus:ring-primary-500 inline-flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Create First Package</span>
                        </a>
                    </div>
                </div>
            @else
                <!-- Test Packages Table -->
                <div class="card-mobile-lg overflow-hidden">
                    <!-- Mobile Cards (Hidden on Desktop) -->
                    <div class="block lg:hidden space-y-4 p-6">
                        @foreach ($testPackages as $testPackage)
                            <div
                                class="bg-neutral-50 dark:bg-neutral-800 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-neutral-900 dark:text-neutral-100 mb-1">
                                            {{ $testPackage->title }}</h3>
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2">
                                            {{ $testPackage->description }}</p>
                                    </div>
                                    <span
                                        class="bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 px-2 py-1 rounded-lg text-xs font-medium">#{{ $testPackage->id }}</span>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span
                                            class="text-sm text-neutral-600 dark:text-neutral-400">{{ $testPackage->duration_minutes }}m</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span
                                            class="text-sm text-neutral-600 dark:text-neutral-400">{{ $testPackage->passing_score }}
                                            pts</span>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between pt-3 border-t border-neutral-200 dark:border-neutral-600">
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400">By
                                        {{ $testPackage->created_by }}</span>

                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('test-packages.show', $testPackage) }}"
                                            class="p-2 text-accent-600 dark:text-accent-400 hover:bg-accent-50 dark:hover:bg-accent-900/20 rounded-lg transition-colors tap-highlight-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0v0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('test-packages.edit', $testPackage) }}"
                                            class="p-2 text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors tap-highlight-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <div x-data="{ showConfirm: false }" class="relative">
                                            <button @click="showConfirm = true"
                                                class="p-2 text-danger-600 dark:text-danger-400 hover:bg-danger-50 dark:hover:bg-danger-900/20 rounded-lg transition-colors tap-highlight-none">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>

                                            <!-- Confirmation Popup -->
                                            <div x-show="showConfirm"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                @click.away="showConfirm = false"
                                                class="absolute right-0 mt-2 w-64 bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700 z-10 p-4">
                                                <h4 class="font-semibold text-neutral-900 dark:text-neutral-100 mb-2">
                                                    Delete Package?</h4>
                                                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">This
                                                    action cannot be undone.</p>
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('test-packages.destroy', $testPackage) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-3 py-1.5 bg-danger-600 text-white text-xs font-medium rounded-lg hover:bg-danger-700 transition-colors tap-highlight-none">
                                                            Delete
                                                        </button>
                                                    </form>
                                                    <button @click="showConfirm = false"
                                                        class="px-3 py-1.5 bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 text-xs font-medium rounded-lg hover:bg-neutral-200 dark:hover:bg-neutral-600 transition-colors tap-highlight-none">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table (Hidden on Mobile) -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                            <thead class="bg-neutral-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Package Info
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Duration
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Passing Score
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Created By
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="bg-white dark:bg-neutral-900 divide-y divide-neutral-200 dark:divide-neutral-700">
                                @foreach ($testPackages as $testPackage)
                                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-3">
                                                <div
                                                    class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                                    <span
                                                        class="text-sm font-semibold text-primary-600 dark:text-primary-400">#{{ $testPackage->id }}</span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p
                                                        class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 truncate">
                                                        {{ $testPackage->title }}</p>
                                                    <p
                                                        class="text-sm text-neutral-500 dark:text-neutral-400 line-clamp-2">
                                                        {{ $testPackage->description }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-neutral-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span
                                                    class="text-sm text-neutral-900 dark:text-neutral-100 font-medium">{{ $testPackage->duration_minutes }}</span>
                                                <span
                                                    class="text-sm text-neutral-500 dark:text-neutral-400">minutes</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-neutral-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span
                                                    class="text-sm text-neutral-900 dark:text-neutral-100 font-medium">{{ $testPackage->passing_score }}</span>
                                                <span
                                                    class="text-sm text-neutral-500 dark:text-neutral-400">points</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="text-sm text-neutral-900 dark:text-neutral-100">{{ $testPackage->created_by }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('test-packages.show', $testPackage) }}"
                                                    class="p-2 text-accent-600 dark:text-accent-400 hover:bg-accent-50 dark:hover:bg-accent-900/20 rounded-lg transition-colors tap-highlight-none"
                                                    title="View Details">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0v0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('test-packages.edit', $testPackage) }}"
                                                    class="p-2 text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors tap-highlight-none"
                                                    title="Edit Package">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <div x-data="{ showConfirm: false }" class="relative">
                                                    <button @click="showConfirm = true"
                                                        class="p-2 text-danger-600 dark:text-danger-400 hover:bg-danger-50 dark:hover:bg-danger-900/20 rounded-lg transition-colors tap-highlight-none"
                                                        title="Delete Package">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>

                                                    <!-- Confirmation Popup -->
                                                    <div x-show="showConfirm"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="transform opacity-0 scale-95"
                                                        x-transition:enter-end="transform opacity-100 scale-100"
                                                        x-transition:leave="transition ease-in duration-75"
                                                        x-transition:leave-start="transform opacity-100 scale-100"
                                                        x-transition:leave-end="transform opacity-0 scale-95"
                                                        @click.away="showConfirm = false"
                                                        class="absolute right-0 mt-2 w-64 bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-700 z-10 p-4">
                                                        <h4
                                                            class="font-semibold text-neutral-900 dark:text-neutral-100 mb-2">
                                                            Delete Package?</h4>
                                                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                                                            This action cannot be undone.</p>
                                                        <div class="flex space-x-2">
                                                            <form
                                                                action="{{ route('test-packages.destroy', $testPackage) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="px-3 py-1.5 bg-danger-600 text-white text-xs font-medium rounded-lg hover:bg-danger-700 transition-colors tap-highlight-none">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                            <button @click="showConfirm = false"
                                                                class="px-3 py-1.5 bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 text-xs font-medium rounded-lg hover:bg-neutral-200 dark:hover:bg-neutral-600 transition-colors tap-highlight-none">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($testPackages->hasPages())
                    <div class="mt-6">
                        <div
                            class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 px-4 py-3">
                            {{ $testPackages->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layout>
