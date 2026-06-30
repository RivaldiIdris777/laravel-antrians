<header class="fixed top-0 left-0 right-0 z-50 bg-primary">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ url('/') }}">
                            <h1 class="text-2xl font-bold gradient-text">Antrians</h1>
                        </a>
                    </div>                                        
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <!-- <button id="darkModeToggle" class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button> -->
                    
                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- Ambil Antrian Button -->
                    <a href="{{ route('login') }}" class="bg-secondary hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Login
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu fixed top-16 left-0 right-0 w-full bg-white/95 dark:bg-gray-800/95 backdrop-blur-lg shadow-xl md:hidden">
            <div class="px-6 py-6 space-y-3">
                <a href="#beranda" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 font-medium">Beranda</a>
                <a href="#tentang" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 font-medium">Tentang</a>
                <a href="#cara-kerja" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 font-medium">Cara Kerja</a>
                <a href="#kontak" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 font-medium">Kontak</a>
            </div>
        </div>
    </header>