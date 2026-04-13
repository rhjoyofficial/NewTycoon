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

    <!-- Fonts: Inter (UI) + Noto Sans Bengali (Bangla + ৳) + Poppins (headings) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..700;1,14..32,300..700&family=Noto+Sans+Bengali:wght@300;400;500;600;700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Core Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

    <!-- Additional Head Scripts & Styles -->
    @stack('head-scripts')
    @stack('styles')

</head>

<body class="font-sans antialiased bg-white">
    <div class="min-h-screen mx-auto max-w-full">
        @include('frontend.partials.navbar')
        <!-- Flash Messages Container -->
        <x-flash-container />
        <main class="pt-16 lg:pt-28">
            @yield('content')
        </main>

        {{-- @include('frontend.partials.newsletter') --}}
        @include('frontend.partials.footer')
    </div>


    <!-- Additional Scripts -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/wishlist.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js"></script>
    <script src="{{ asset('js/gsap/gsap-featured-products.js') }}"></script>
    {{-- <script src="{{ asset('js/gsap/gsap-tilt-category-card.js') }}"></script> --}}
    <script src="{{ asset('js/gsap/gsap-offer-products.js') }}"></script>

    @stack('scripts')

</body>

</html>
