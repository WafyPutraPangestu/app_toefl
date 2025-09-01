<x-layout>
    <!-- Toast Notifications -->
    <div x-data="{
        showSuccess: false,
        showError: false,
        successMessage: '',
        errorMessage: '',
        init() {
            @if (session('success')) this.successMessage = '{{ session('success') }}';
                this.showSuccess = true;
                setTimeout(() => this.showSuccess = false, 5000); @endif
            @if ($errors->any()) this.errorMessage = '{{ $errors->first() }}';
                this.showError = true;
                setTimeout(() => this.showError = false, 5000); @endif
        }
    }" class="fixed top-4 right-4 z-50 space-y-2">
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
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400" x-text="successMessage">
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

        <!-- Error Toast -->
        <div x-show="showError" x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="max-w-sm w-full bg-white dark:bg-neutral-800 shadow-lg rounded-2xl pointer-events-auto ring-1 ring-black ring-opacity-5 border border-danger-200 dark:border-danger-700">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 h-8 bg-danger-100 dark:bg-danger-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-danger-600 dark:text-danger-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400" x-text="errorMessage"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="showError = false"
                            class="rounded-lg inline-flex text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-danger-500">
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
    <div class="min-h-screen  dark:bg-neutral-900 py-6 px-4 sm:px-6 lg:px-8">
        <div class=" mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-2">
                    <div
                        class="w-10 h-10 bg-warning-100 dark:bg-warning-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-600 dark:text-neutral-400">Edit Test Package</h1>
                        <p class="text-neutral-600 dark:text-neutral-400">Update test package information</p>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-neutral-500 dark:text-neutral-400">
                    <a href="{{ route('test-packages.index') }}"
                        class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Test Packages</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span>{{ $testPackage->title }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span>Edit</span>
                </nav>
            </div>

            <!-- Form Container -->
            <div class="card-mobile-lg py-10 px-10">
                <form action="{{ route('test-packages.update', $testPackage) }}" method="POST" x-data="{
                    isSubmitting: false,
                    handleSubmit() {
                        this.isSubmitting = true;
                        this.$el.submit();
                    }
                }"
                    @submit.prevent="handleSubmit()" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Test Package Title -->
                    <div class="space-y-2">
                        <label for="title"
                            class="block text-sm font-semibold text-neutral-600 dark:text-neutral-400">
                            Test Package Title
                            <span class="text-danger-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $testPackage->title) }}" required
                                class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-neutral-600 dark:text-neutral-400 placeholder-neutral-500 dark:placeholder-neutral-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 tap-highlight-none @error('title') border-danger-500 focus:ring-danger-500 focus:border-danger-500 @enderror"
                                placeholder="Enter test package title">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a.997.997 0 01-.707.293H7a4 4 0 01-4-4V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                        </div>
                        @error('title')
                            <p class="text-sm text-danger-600 dark:text-danger-400 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description"
                            class="block text-sm font-semibold text-neutral-600 dark:text-neutral-400">
                            Description
                            <span class="text-danger-500">*</span>
                        </label>
                        <textarea name="description" id="description" required rows="4"
                            class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-neutral-600 dark:text-neutral-400 placeholder-neutral-500 dark:placeholder-neutral-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 resize-none tap-highlight-none @error('description') border-danger-500 focus:ring-danger-500 focus:border-danger-500 @enderror"
                            placeholder="Describe the test package content and objectives">{{ old('description', $testPackage->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-danger-600 dark:text-danger-400 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Duration and Score Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Duration -->
                        <div class="space-y-2">
                            <label for="duration_minutes"
                                class="block text-sm font-semibold text-neutral-600 dark:text-neutral-400">
                                Duration
                                <span class="text-danger-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="duration_minutes" id="duration_minutes"
                                    value="{{ old('duration_minutes', $testPackage->duration_minutes) }}"
                                    min="1" required
                                    class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-neutral-600 dark:text-neutral-400 placeholder-neutral-500 dark:placeholder-neutral-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 tap-highlight-none @error('duration_minutes') border-danger-500 focus:ring-danger-500 focus:border-danger-500 @enderror"
                                    placeholder="120">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-sm text-neutral-500 dark:text-neutral-400">minutes</span>
                                </div>
                            </div>
                            @error('duration_minutes')
                                <p class="text-sm text-danger-600 dark:text-danger-400 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Passing Score -->
                        <div class="space-y-2">
                            <label for="passing_score"
                                class="block text-sm font-semibold text-neutral-600 dark:text-neutral-400">
                                Passing Score
                                <span class="text-danger-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="passing_score" id="passing_score"
                                    value="{{ old('passing_score', $testPackage->passing_score) }}" min="0"
                                    max="100" required
                                    class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-xl text-neutral-600 dark:text-neutral-400 placeholder-neutral-500 dark:placeholder-neutral-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 tap-highlight-none @error('passing_score') border-danger-500 focus:ring-danger-500 focus:border-danger-500 @enderror"
                                    placeholder="70">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-sm text-neutral-500 dark:text-neutral-400">points</span>
                                </div>
                            </div>
                            @error('passing_score')
                                <p class="text-sm text-danger-600 dark:text-danger-400 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row-reverse gap-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                        <!-- Submit Button -->
                        <button type="submit" :disabled="isSubmitting"
                            class="btn-mobile-lg gradient-primary text-white focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center justify-center space-x-2">
                            <svg x-show="isSubmitting" class="animate-spin w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <svg x-show="!isSubmitting" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            <span x-text="isSubmitting ? 'Updating...' : 'Update Test Package'"></span>
                        </button>

                        <!-- Cancel Button -->
                        <a href="{{ route('test-packages.index') }}"
                            class="btn-mobile-lg bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-300 dark:border-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-700 focus:ring-neutral-500 inline-flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
