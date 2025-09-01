<!-- Modern TOEFL Navigation Component - No Dropdown Version -->
<nav class="relative shadow-lg border-b border-primary-500/20"
    style="background: linear-gradient(to right, var(--color-primary-600), var(--color-primary-700), var(--color-primary-800));"
    x-data="{
        mobileMenuOpen: false
    }">

    <!-- Main Navigation Bar -->
    <div class="mx-auto  px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <!-- Logo & Brand -->
            <div class="flex items-center space-x-4">
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 tap-highlight-none focus:outline-none focus:ring-2 focus:ring-white/20">
                    <svg class="h-6 w-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Brand Logo -->
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-white tracking-tight">TOEFL Academy</h1>
                        <p class="text-xs text-white/70 -mt-1">Excellence in English</p>
                    </div>
                </div>
            </div>

            <!-- Desktop Navigation Menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-2">
                <!-- Home -->
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200 font-medium text-sm tap-highlight-none">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Home</span>
                    </div>
                </a>

                <!-- User Dashboard -->
                @can('user')
                    <a href="{{ route('user.dashboard') }}"
                        class="px-4 py-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200 font-medium text-sm tap-highlight-none">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>
                @endcan

                <!-- Admin Menu Items (Direct Links) -->
                @can('admin')
                    <a href="{{ route('test-packages.index') }}"
                        class="px-4 py-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200 font-medium text-sm tap-highlight-none">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Test Packages</span>
                        </div>
                    </a>

                    <a href="{{ route('manajemen-user.index') }}"
                        class="px-4 py-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200 font-medium text-sm tap-highlight-none">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                            <span>Users</span>
                        </div>
                    </a>

                    <a href="{{ route('questions.index') }}"
                        class="px-4 py-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200 font-medium text-sm tap-highlight-none">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Questions</span>
                        </div>
                    </a>

                    <a href="{{ route('manajemen-reading.index') }}"
                        class="px-4 py-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200 font-medium text-sm tap-highlight-none">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Reading</span>
                        </div>
                    </a>
                @endcan
            </div>

            <!-- Right Side: Theme Toggle & Auth -->
            <div class="flex items-center space-x-3">
                <!-- Dark Mode Toggle -->
                <button @click="isDark = !isDark; document.documentElement.classList.toggle('dark', isDark)"
                    class="p-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 tap-highlight-none focus:outline-none focus:ring-2 focus:ring-white/20">
                    <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                @auth
                    <!-- User Info & Logout (Inline) -->
                    <div class="hidden sm:flex items-center space-x-3 pl-3 border-l border-white/20">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-white/90">{{ Auth::user()->name ?? 'User' }}</span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1.5 bg-red-600/90 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-all duration-200 tap-highlight-none focus:outline-none focus:ring-2 focus:ring-red-300/50">
                                <div class="flex items-center space-x-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Logout</span>
                                </div>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Auth Links -->
                    <div class="hidden sm:flex items-center space-x-2">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 tap-highlight-none text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                <span>Login</span>
                            </div>
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 text-primary-700 rounded-xl transition-all duration-200 tap-highlight-none text-sm font-medium shadow-sm"
                            style="background: white;">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                <span>Register</span>
                            </div>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="mobileMenuOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 lg:hidden"></div>

    <!-- Mobile Sidebar -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 h-full w-80 bg-white dark:bg-neutral-900 shadow-2xl z-50 lg:hidden overflow-y-auto">

        <!-- Mobile Menu Header -->
        <div class="p-6 text-white"
            style="background: linear-gradient(to right, var(--color-primary-600), var(--color-primary-700));">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg">TOEFL Academy</h2>
                        <p class="text-xs text-white/70">Excellence in English</p>
                    </div>
                </div>
                <button @click="mobileMenuOpen = false"
                    class="p-2 rounded-lg hover:bg-white/10 transition-colors tap-highlight-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Items -->
        <div class="p-4 space-y-2">
            <!-- Home -->
            <a href="{{ route('home') }}"
                class="flex items-center px-4 py-3 text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition-all duration-200 tap-highlight-none">
                <svg class="w-5 h-5 mr-3 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="font-medium">Home</span>
            </a>

            @can('user')
                <!-- User Dashboard -->
                <a href="{{ route('user.dashboard') }}"
                    class="flex items-center px-4 py-3 text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition-all duration-200 tap-highlight-none">
                    <svg class="w-5 h-5 mr-3 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
            @endcan

            @can('admin')
                <!-- Admin Section Header -->
                <div class="pt-4 pb-2">
                    <div class="flex items-center px-4">
                        <div
                            class="w-6 h-6 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-3 h-3 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-neutral-600 dark:text-neutral-300 uppercase tracking-wide">
                            Admin Panel</h3>
                    </div>
                    <div class="mx-4 mt-2 border-b border-neutral-200 dark:border-neutral-700"></div>
                </div>

                <!-- Test Packages -->
                <a href="{{ route('test-packages.index') }}"
                    class="flex items-center px-4 py-3 text-neutral-700 dark:text-neutral-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 dark:hover:text-blue-300 rounded-xl transition-all duration-200 tap-highlight-none">
                    <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">Test Packages</span>
                </a>

                <!-- User Management -->
                <a href="{{ route('manajemen-user.index') }}"
                    class="flex items-center px-4 py-3 text-neutral-700 dark:text-neutral-200 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:text-purple-700 dark:hover:text-purple-300 rounded-xl transition-all duration-200 tap-highlight-none">
                    <div
                        class="w-6 h-6 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">User Management</span>
                </a>

                <!-- Question Bank -->
                <a href="{{ route('questions.index') }}"
                    class="flex items-center px-4 py-3 text-neutral-700 dark:text-neutral-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-300 rounded-xl transition-all duration-200 tap-highlight-none">
                    <div
                        class="w-6 h-6 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">Question Bank</span>
                </a>

                <!-- Reading Management -->
                <a href="{{ route('manajemen-reading.index') }}"
                    class="flex items-center px-4 py-3 text-neutral-700 dark:text-neutral-200 hover:bg-amber-50 dark:hover:bg-amber-900/20 hover:text-amber-700 dark:hover:text-amber-300 rounded-xl transition-all duration-200 tap-highlight-none">
                    <div
                        class="w-6 h-6 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="font-medium">Reading Management</span>
                </a>
            @endcan

            @guest
                <!-- Auth Links untuk Mobile -->
                <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4 mt-4 space-y-2">
                    <a href="{{ route('login') }}"
                        class="flex items-center px-4 py-3 text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition-all duration-200 tap-highlight-none">
                        <svg class="w-5 h-5 mr-3 text-neutral-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium">Login</span>
                    </a>

                    <a href="{{ route('register') }}"
                        class="flex items-center px-4 py-3 text-white rounded-xl transition-all duration-200 tap-highlight-none"
                        style="background: var(--color-primary-600);">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span class="font-medium">Register</span>
                    </a>
                </div>
            @endguest

            @auth
                <!-- User Info & Logout untuk Mobile -->
                <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4 mt-4">
                    <!-- User Info -->
                    <div class="flex items-center px-4 py-3 mb-2">
                        <div
                            class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-neutral-900 dark:text-neutral-100">
                                {{ Auth::user()->name ?? 'User' }}</div>
                            <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ Auth::user()->email ?? '' }}
                            </div>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-200 tap-highlight-none">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        <!-- Mobile Menu Footer -->
        <div
            class="absolute bottom-0 left-0 right-0 p-4 bg-neutral-50 dark:bg-neutral-800 border-t border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-center space-x-4 text-xs text-neutral-500 dark:text-neutral-400">
                <span>&copy; 2025 TOEFL Academy</span>
                <span>•</span>
                <span>Excellence in English</span>
            </div>
        </div>
    </div>
</nav>
