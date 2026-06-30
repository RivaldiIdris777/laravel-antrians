<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />    
    <title>@yield('title', 'Dashboard | Management System')</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon/favicon-32x32.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 font-sans text-gray-800 antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- ═══════════════ SIDEBAR ═══════════════ -->
        @include('layouts.admin.sidebar')
        <!-- ═══════════════ END SIDEBAR ═══════════════ -->


        <!-- Wrapper kanan -->
        <div class="flex flex-col flex-1 overflow-hidden min-w-0">
            <!-- ═══════════════ HEADER ═══════════════ -->
            @include('layouts.admin.header')
            <!-- ═══════════════ END HEADER ═══════════════ -->


            <!-- ═══════════════ MAIN ═══════════════ -->
            <main id="main-content" class="flex-1 overflow-y-auto p-6 bg-slate-100">
               @yield('content')
            </main>
            <!-- ═══════════════ END MAIN ═══════════════ -->


            <!-- ═══════════════ FOOTER ═══════════════ -->
            @include('layouts.admin.footer')
            <!-- ═══════════════ END FOOTER ═══════════════ -->
        </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>

    @include('sweetalert::alert')

    @stack('scripts')
</body>

</html>
