<header class="fixed top-0 left-0 right-0 z-50 bg-primary shadow-md">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}">
                        <h1 class="text-2xl font-bold text-white">Antrians</h1>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:block ml-10">
                    <div class="flex items-baseline space-x-8">
                        <a href="#beranda"
                            class="text-white/90 hover:text-secondary transition-colors duration-200 font-medium">Home</a>
                        <a href="#cara-kerja"
                            class="text-white/90 hover:text-secondary transition-colors duration-200 font-medium">Cara
                            Kerja</a>
                        <a href="#kontak"
                            class="text-white/90 hover:text-secondary transition-colors duration-200 font-medium">Contact</a>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-4">
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn"
                    class="md:hidden p-2 rounded-lg hover:bg-white/10 transition-colors duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Login Button -->
                <a href="{{ route('login') }}"
                    class="bg-secondary hover:bg-orange-600 text-white px-6 py-2 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu"
        class="mobile-menu fixed top-16 left-0 right-0 w-full bg-primary shadow-xl md:hidden">
        <div class="px-6 py-6 space-y-3">
            <a href="#beranda"
                class="block px-4 py-3 text-white/80 hover:text-secondary hover:bg-white/10 rounded-xl transition-all duration-200 font-medium">Beranda</a>
            <a href="#cara-kerja"
                class="block px-4 py-3 text-white/80 hover:text-secondary hover:bg-white/10 rounded-xl transition-all duration-200 font-medium">Cara
                Kerja</a>
            <a href="#kontak"
                class="block px-4 py-3 text-white/80 hover:text-secondary hover:bg-white/10 rounded-xl transition-all duration-200 font-medium">Kontak</a>
        </div>
    </div>
</header>
