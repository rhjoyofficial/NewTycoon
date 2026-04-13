@extends('frontend.layouts.app')

@section('title', 'Server Error')
@section('description', 'Something went wrong on our server')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-16 min-h-[60vh] flex items-center justify-center">
        <div class="text-center">
            <div class="mb-8">
                <div class="text-9xl font-bold text-primary/20 mb-4 font-poppins">500</div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">Server Error</h1>
                <p class="text-lg text-gray-600 max-w-xl mx-auto mb-8 font-inter">
                    Something went wrong on our servers. Our team has been notified and is working to fix the issue.
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
                <button onclick="window.location.reload()"
                    class="px-8 py-3 bg-accent hover:bg-accent-dark text-white font-semibold rounded-lg transition-colors font-inter">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh Page
                    </span>
                </button>
            </div>

            <!-- Status Updates -->
            <div class="max-w-md mx-auto bg-white border border-gray-200 rounded-xl p-6 mb-8">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></div>
                    <span class="font-semibold text-gray-900 font-inter">System Status</span>
                </div>
                <p class="text-gray-600 mb-4 font-inter">We're experiencing technical difficulties. Please try again in a
                    few minutes.</p>
                <div class="text-sm text-gray-500 font-inter">Last updated: {{ now()->format('h:i A') }}</div>
            </div>

            <!-- Contact Support -->
            <div class="bg-primary/5 rounded-xl p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-3 font-poppins">Need immediate help?</h3>
                <p class="text-gray-600 mb-4 font-inter">If the problem persists, contact our support team.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="mailto:support@tycoon.com" class="text-primary hover:text-primary-dark font-medium font-inter">
                        support@tycoon.com
                    </a>
                    <span class="hidden sm:block text-gray-400">|</span>
                    <a href="tel:+880XXXXXXXXXX" class="text-primary hover:text-primary-dark font-medium font-inter">
                        +880 XXX-XXXXXXX
                    </a>
                </div>
            </div>

            <!-- What to Do -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h4 class="text-lg font-bold text-gray-900 mb-4 font-poppins">What you can do:</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                    <div class="text-center">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 font-inter">Wait a few minutes and try again</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 font-inter">Clear your browser cache and cookies</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 font-inter">Try using a different browser</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
