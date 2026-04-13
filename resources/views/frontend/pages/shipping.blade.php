@extends('frontend.layouts.app')

@section('title', 'Shipping Information')
@section('description', 'Shipping policies, delivery times, and tracking information')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">Shipping Information</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto font-inter">Everything you need to know about shipping and
                delivery</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Shipping Options -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-poppins">Shipping Options</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 font-poppins">Standard Shipping</h3>
                        </div>
                        <p class="text-gray-600 mb-3 font-inter">3-5 business days</p>
                        <p class="text-gray-600 text-sm font-inter">Free shipping on orders over <span
                                class="font-bengali">৳</span> 5000</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 font-poppins">Express Shipping</h3>
                        </div>
                        <p class="text-gray-600 mb-3 font-inter">1-2 business days</p>
                        <p class="text-gray-600 text-sm font-inter">Additional charge applies</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Areas -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-poppins">Shipping Areas</h2>
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div class="p-6 border-b md:border-b-0 md:border-r border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 font-poppins">Dhaka City</h3>
                            <ul class="space-y-2 text-gray-600 font-inter">
                                <li>• Free standard shipping</li>
                                <li>• Next day delivery available</li>
                                <li>• Cash on delivery</li>
                            </ul>
                        </div>
                        <div class="p-6 border-b md:border-b-0 md:border-r border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 font-poppins">Other Cities</h3>
                            <ul class="space-y-2 text-gray-600 font-inter">
                                <li>• 2-3 business days</li>
                                <li>• Free shipping over <span class="font-bengali">৳</span>5000</li>
                                <li>• Online payment preferred</li>
                            </ul>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 font-poppins">International</h3>
                            <ul class="space-y-2 text-gray-600 font-inter">
                                <li>• 5-10 business days</li>
                                <li>• Shipping charges apply</li>
                                <li>• Customs duties may apply</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tracking Information -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-poppins">Track Your Order</h2>
                <div class="bg-gradient-to-r from-primary/5 to-accent/5 rounded-xl p-6">
                    <p class="text-gray-600 mb-4 font-inter">Once your order is shipped, you'll receive a tracking number
                        via email. You can track your order:</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('orders.track') }}"
                            class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors text-center font-inter">
                            Track Order
                        </a>
                        <a href="{{ route('contact') }}"
                            class="px-6 py-3 bg-white hover:bg-gray-50 text-gray-800 font-semibold rounded-lg border border-gray-300 transition-colors text-center font-inter">
                            Need Help?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
