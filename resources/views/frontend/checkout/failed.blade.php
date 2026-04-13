@extends('frontend.layouts.app')

@section('title', 'Checkout Failed')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-2xl mx-auto px-4 text-center">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout Failed</h1>
            <p class="text-gray-600 mb-8">Unfortunately, we couldn't process your order.</p>

            <div class="flex gap-3 justify-center">
                <a href="{{ route('cart.index') }}"
                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-lg">
                    Back to Cart
                </a>
                <a href="{{ route('contact') }}"
                    class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
@endsection
