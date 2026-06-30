<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard | Antrian Management System')</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon/favicon-32x32.png') }}" />    
        
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Heroicons -->
    <script src="https://unpkg.com/heroicons@2.0.18/24/outline/index.js" type="module"></script>
    <link rel="stylesheet" href="{{ asset('css/client.css') }}" />
    @stack('styles')
    <!-- TailwindCSS Config -->            
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary dark:bg-primary text-gray-900 dark:text-gray-100 transition-colors duration-300">
    
    <!-- Header -->
    @include('layouts.client.header')
    
    <!-- Main Content -->
    <main class="pt-16 min-h-screen flex flex-col">
        <!-- Hero Section -->
        <section id="beranda" class="relative overflow-hidden flex-1 flex flex-col">
            @yield('hero')
        </section>                
    </main>
    
    <!-- Footer -->
     @include('layouts.client.footer')    
    
    @stack('scripts')
</body>
</html>