<x-layout>
    <!-- Main Content -->
    <div class="min-h-screen  dark:bg-neutral-900 py-6 px-4 sm:px-6 lg:px-8">
        <div class=" mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-2">
                    <div
                        class="w-10 h-10 bg-accent-100 dark:bg-accent-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0v0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-600 dark:text-neutral-400">Test Package Details</h1>
                        <p class="text-neutral-600 dark:text-neutral-400">Comprehensive information about this test
                            package</p>
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
                </nav>
            </div>

            <!-- Main Card -->
            <div class="card-mobile-lg px-10 py-10">
                <!-- Package Header -->
                <div class="border-b border-neutral-200 dark:border-neutral-700 pb-6 mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-2xl flex items-center justify-center">
                                <span
                                    class="text-xl font-bold text-primary-600 dark:text-primary-400">#{{ $testPackage->id }}</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-neutral-600 dark:text-neutral-400 mb-1">
                                    {{ $testPackage->title }}</h2>
                                <div class="flex items-center space-x-4 text-sm text-neutral-500 dark:text-neutral-400">
                                    <span>Created by {{ $testPackage->created_by }}</span>
                                    <span>•</span>
                                    <span>Package ID: {{ $testPackage->id }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('test-packages.edit', $testPackage) }}"
                                class="btn-mobile bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 hover:bg-primary-200 dark:hover:bg-primary-900/50 border border-primary-200 dark:border-primary-700 focus:ring-primary-500 inline-flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Edit</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Package Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Duration Card -->
                    <div
                        class="bg-neutral-50 dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700">
                        <div class="flex items-center space-x-3 mb-2">
                            <div
                                class="w-10 h-10 bg-warning-100 dark:bg-warning-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-warning-600 dark:text-warning-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-neutral-600 dark:text-neutral-400">Duration</h3>
                        </div>
                        <div class="flex items-baseline space-x-1">
                            <span
                                class="text-2xl font-bold text-neutral-600 dark:text-neutral-400">{{ $testPackage->duration_minutes }}</span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">minutes</span>
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Total test duration</p>
                    </div>

                    <!-- Passing Score Card -->
                    <div
                        class="bg-neutral-50 dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700">
                        <div class="flex items-center space-x-3 mb-2">
                            <div
                                class="w-10 h-10 bg-accent-100 dark:bg-accent-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-accent-600 dark:text-accent-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-neutral-600 dark:text-neutral-400">Passing Score</h3>
                        </div>
                        <div class="flex items-baseline space-x-1">
                            <span
                                class="text-2xl font-bold text-neutral-600 dark:text-neutral-400">{{ $testPackage->passing_score }}</span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">points</span>
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Minimum to pass</p>
                    </div>

                    <!-- Status Card -->
                    <div
                        class="bg-neutral-50 dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700">
                        <div class="flex items-center space-x-3 mb-2">
                            <div
                                class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-neutral-600 dark:text-neutral-400">Status</h3>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent-100 dark:bg-accent-900/30 text-accent-800 dark:text-accent-200">
                                <span class="w-1.5 h-1.5 bg-accent-400 rounded-full mr-1.5"></span>
                                Active
                            </span>
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Ready for use</p>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="mb-8">
                    <h3
                        class="text-lg font-semibold text-neutral-600 dark:text-neutral-400 mb-4 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Description</span>
                    </h3>
                    <div
                        class="bg-neutral-50 dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700">
                        <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed">
                            {{ $testPackage->description }}</p>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Test Overview -->
                    <div
                        class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 rounded-xl p-6 border border-primary-200 dark:border-primary-700">
                        <h4
                            class="font-semibold text-primary-900 dark:text-primary-100 mb-3 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Test Overview</span>
                        </h4>
                        <ul class="space-y-2 text-sm text-primary-800 dark:text-primary-200">
                            <li class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Comprehensive TOEFL assessment</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Automated scoring system</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Detailed performance analytics</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Actions -->
                    <div
                        class="bg-gradient-to-br from-accent-50 to-accent-100 dark:from-accent-900/20 dark:to-accent-800/20 rounded-xl p-6 border border-accent-200 dark:border-accent-700">
                        <h4
                            class="font-semibold text-accent-900 dark:text-accent-100 mb-3 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-accent-600 dark:text-accent-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Quick Actions</span>
                        </h4>
                        <div class="space-y-3">
                            <a href="{{ route('test-packages.edit', $testPackage) }}"
                                class="w-full btn-mobile bg-white dark:bg-neutral-800 text-accent-700 dark:text-accent-300 border border-accent-200 dark:border-accent-700 hover:bg-accent-50 dark:hover:bg-accent-900/10 focus:ring-accent-500 inline-flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Edit Package</span>
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <a href="{{ route('test-packages.index') }}"
                        class="btn-mobile-lg bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-300 dark:border-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-700 focus:ring-neutral-500 inline-flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Back to Test Packages</span>
                    </a>

                    <div class="flex gap-3 sm:ml-auto">
                        <a href="{{ route('test-packages.edit', $testPackage) }}"
                            class="btn-mobile-lg gradient-primary text-white focus:ring-primary-500 inline-flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit Package</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
