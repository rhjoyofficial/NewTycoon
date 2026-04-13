<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-scrollbar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name', 'Tycoon') }}
        @else
            Admin - {{ config('app.name', 'Tycoon') }}
        @endif
    </title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cambay:ital,wght@0,400;0,700;1,400;1,700&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=poppins:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Sans+Bengali:wght@100..900&display=swap"
        rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Core Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            @include('admin.partials.topbar')
            <!-- Flash Messages Container -->
            <x-flash-container />
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4 no-scrollbar">
                <div class="max-w-8xl mx-auto">
                    <!-- Breadcrumb -->
                    @include('admin.partials.breadcrumb')
                    <!-- Content -->
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            @include('admin.partials.footer')
        </div>
    </div>

    <!-- Alpine -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script> --}}
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{-- Global Button Lock Utility --}}
    <script src="{{ asset('js/button-lock.js') }}"></script>
    <!-- Page specific scripts -->
    @stack('scripts')
</body>

</html>
