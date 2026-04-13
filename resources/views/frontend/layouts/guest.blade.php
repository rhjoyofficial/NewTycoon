<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-scrollbar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Tycoon') }}@hasSection('title')
            - @yield('title')
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cambay:ital,wght@0,400;0,700;1,400;1,700&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=poppins:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Push Styles & Scripts -->
    @stack('head-scripts')
    @stack('styles')
</head>

<body class="font-sans antialiased bg-white">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
        <!-- Logo -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4">
            <a href="{{ url('/') }}" class="flex justify-center">
                <img src="{{ asset('images/bk-logo.png') }}" alt="BK Logo" class="h-12 w-auto">
            </a>
        </div>

        <!-- Card Container -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4">
            <!-- Authentication Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Card Header (optional) -->
                @hasSection('card-header')
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 text-center">
                            @yield('card-header')
                        </h2>
                    </div>
                @endif

                <!-- Card Content -->
                <div class="px-6 py-8">
                    <!-- Main Content -->                  
                    @yield('content')
                </div>

                <!-- Card Footer (optional) -->
                @hasSection('card-footer')
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="text-center text-sm text-gray-600">
                            @yield('card-footer')
                        </div>
                    </div>
                @endif
            </div>

            <!-- Additional Links (like back to home, etc.) -->
            @hasSection('additional-links')
                <div class="mt-6 text-center">
                    @yield('additional-links')
                </div>
            @endif
        </div>

        <!-- Back to Home -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 text-center">
            <a href="{{ url('/') }}"
                class="text-sm text-gray-600 hover:text-primary transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Home
            </a>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
