@extends('frontend.layouts.app')

@section('title', 'Page Not Found')
@section('description', 'The page you are looking for could not be found')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-16 min-h-[60vh] flex items-center justify-center">
        <div class="text-center">
            <div class="mb-8">
                <div class="text-9xl font-bold text-primary/20 mb-4 font-poppins">404</div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">Page Not Found</h1>
                <p class="text-lg text-gray-600 max-w-xl mx-auto mb-8 font-inter">
                    The page you are looking for might have been removed, had its name changed, or is temporarily
                    unavailable.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="{{ url('/') }}"
                    class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors font-inter">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Go to Homepage
                    </span>
                </a>
                <a href="{{ route('products.index') }}"
                    class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-800 font-semibold rounded-lg border border-gray-300 transition-colors font-inter">
                    Browse Products
                </a>
                <button onclick="window.history.back()"
                    class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-800 font-semibold rounded-lg border border-gray-300 transition-colors font-inter">
                    Go Back
                </button>
            </div>

            <!-- Search -->
            <div class="max-w-md mx-auto">
                <p class="text-gray-600 mb-4 font-inter">Try searching for what you're looking for:</p>
                <div class="relative">
                    <form action="{{ route('search') }}" method="GET" class="flex">
                        <input type="text" name="q" placeholder="Search products..."
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none font-inter">
                        <button type="submit"
                            class="px-6 bg-primary hover:bg-primary-dark text-white font-semibold rounded-r-lg transition-colors font-inter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-gray-600 mb-4 font-inter">You might also be looking for:</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('products.index') }}"
                        class="text-primary hover:text-primary-dark font-medium font-inter">All Products</a>
                    <a href="{{ route('categories.index') }}"
                        class="text-primary hover:text-primary-dark font-medium font-inter">Categories</a>
                    <a href="{{ route('support') }}"
                        class="text-primary hover:text-primary-dark font-medium font-inter">Support</a>
                    <a href="{{ route('contact') }}"
                        class="text-primary hover:text-primary-dark font-medium font-inter">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
@endsection
