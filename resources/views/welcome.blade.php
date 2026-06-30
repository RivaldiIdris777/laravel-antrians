<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrians - Sistem Antrian Digital Modern</title>            
    <link rel="icon" type="image/png" href="{{ asset('image/favicon/favicon-32x32.png') }}" />
    <!-- Heroicons -->
    <script src="https://unpkg.com/heroicons@2.0.18/24/outline/index.js" type="module"></script>
    
    <!-- TailwindCSS Config -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>        
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
            
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        @media (max-width: 640px) {
            .mobile-menu {
                max-height: 0;
                opacity: 0;
                overflow: hidden;
                transition: max-height 0.4s ease, opacity 0.3s ease;
            }
            
            .mobile-menu.active {
                max-height: 400px;
                opacity: 1;
            }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary dark:bg-primary text-gray-900 dark:text-gray-100 transition-colors duration-300">
    
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 glass-effect">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold gradient-text">Antrians</h1>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:block ml-10">
                        <div class="flex items-baseline space-x-8">
                            <a href="#beranda" class=" hover:text-secondary dark:hover:text-secondary transition-colors duration-200 font-medium">Home</a>                            
                            <a href="#cara-kerja" class=" hover:text-secondary dark:hover:text-secondary transition-colors duration-200 font-medium">Cara Kerja</a>
                            <a href="#kontak" class=" hover:text-secondary dark:hover:text-secondary transition-colors duration-200 font-medium">Contact</a>
                        </div>
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
                <a href="#cara-kerja" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 font-medium">Cara Kerja</a>
                <a href="#kontak" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 font-medium">Kontak</a>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="pt-16">
        <!-- Hero Section -->
        <section id="beranda" class="relative overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                            Sistem Antrian Digital <span class="text-secondary">Modern</span>
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            Kelola antrian dengan lebih efisien, transparan, dan nyaman. Sistem antrian digital yang dirancang untuk meningkatkan pengalaman pelanggan dan efisiensi layanan.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button class="bg-primary hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                Ambil Antrian Sekarang
                            </button>
                            <button class="bg-secondary hover:bg-orange-500 text-white px-8 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                Pelajari Lebih Lanjut
                            </button>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="animate-float">
                            <div class="relative">
                                <!-- Queue System Illustration -->
                                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
                                    <div class="space-y-6">
                                        <!-- Queue Display -->
                                        <div class="bg-primary rounded-xl p-6 text-white">
                                            <div class="text-center">
                                                <p class="text-sm opacity-90">Nomor Antrian Saat Ini</p>
                                                <p class="text-5xl font-bold mt-2">A-045</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Queue List -->
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                                <span class="font-medium">A-043</span>
                                                <span class="text-sm text-gray-500">Loket 1</span>
                                            </div>
                                            <div class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                                <span class="font-medium">A-044</span>
                                                <span class="text-sm text-gray-500">Loket 2</span>
                                            </div>
                                        </div>
                                                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Information Section -->
        <section class="py-20 bg-secondary dark:bg-secondary">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Active Counters -->
                    <div class="bg-white dark:bg-primary rounded-2xl p-8 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-light dark:bg-light p-3 rounded-xl">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">12</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Loket Aktif</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Semua loket beroperasi normal</p>
                    </div>
                    
                    <!-- Total Queue -->
                    <div class="bg-white dark:bg-primary rounded-2xl p-8 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-success/10 dark:bg-success/20 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">248</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Antrian Hari Ini</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Diproses dengan efisien</p>
                    </div>
                    
                    <!-- Service Time Estimate -->
                    <div class="bg-white dark:bg-primary rounded-2xl p-8 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-warning/10 dark:bg-warning/20 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">15</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Estimasi Waktu (menit)</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Rata-rata waktu layanan</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Cara Kerja Session Section -->
        <section id="cara-kerja" class="py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Cara Kerja Sistem Antrian</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Proses antrian yang sederhana dan efisien untuk meningkatkan pengalaman pengunjung
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center group">
                        <div class="relative mb-6">
                            <div class="w-20 h-20 mx-auto bg-secondary rounded-full flex items-center justify-center text-white text-2xl font-bold group-hover:scale-110 transition-transform duration-300">
                                1
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Ambil Antrian</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Pilih unit yang ingin dituju 
                        </p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="text-center group">
                        <div class="relative mb-6">
                            <div class="w-20 h-20 mx-auto bg-secondary rounded-full flex items-center justify-center text-white text-2xl font-bold group-hover:scale-110 transition-transform duration-300">
                                2
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Menunggu Giliran</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Pantau nomor antrian melalui layar digital loket
                        </p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="text-center group">
                        <div class="relative mb-6">
                            <div class="w-20 h-20 mx-auto bg-secondary rounded-full flex items-center justify-center text-white text-2xl font-bold group-hover:scale-110 transition-transform duration-300">
                                3
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Dipanggil Loket</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Akan muncul pemberitahuan di layar dan mengeluarkan suara sesuai nomor antrian anda
                        </p>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="text-center group">
                        <div class="relative mb-6">
                            <div class="w-20 h-20 mx-auto bg-secondary rounded-full flex items-center justify-center text-white text-2xl font-bold group-hover:scale-110 transition-transform duration-300">
                                4
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Selesai</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Layanan selesai
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <!-- Footer -->
    <footer id="kontak" class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-2xl font-bold mb-4 gradient-text">Antrians</h3>
                    <p class="text-gray-400 mb-4">
                        Sistem antrian berrbasis web untuk kebutuhan tempat usaha anda.
                    </p>
                    <div class="flex space-x-4">                        
                        <a href="https://www.linkedin.com/in/rivaldi-idris/" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="text-gray-400 hover:text-white transition-colors duration-200">Beranda</a></li>                        
                        <li><a href="#cara-kerja" class="text-gray-400 hover:text-white transition-colors duration-200">Cara Kerja</a></li>
                        <li><a href="#kontak" class="text-gray-400 hover:text-white transition-colors duration-200">Kontak</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak Kami</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            rivaldi905.....
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +62 896 027* ****
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            JL. Junior IT Menuju Senior IT
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2026 Antrians. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                    
                    // Toggle icon between hamburger and close (X)
                    const icon = mobileMenuBtn.querySelector('svg');
                    if (mobileMenu.classList.contains('active')) {
                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                    } else {
                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
                    }
                });
                
                // Close menu when clicking a link inside
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.remove('active');
                        const icon = mobileMenuBtn.querySelector('svg');
                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
                    });
                });
                
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                        mobileMenu.classList.remove('active');
                        const icon = mobileMenuBtn.querySelector('svg');
                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
                    }
                });
            }
        });
    </script>
</body>
</html>