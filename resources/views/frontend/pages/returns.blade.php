@extends('frontend.layouts.app')

@section('title', 'Returns & Refunds')
@section('description', 'Our return policy and refund process')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">Returns & Refunds</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto font-inter">Our hassle-free return and refund policy</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Return Policy -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-poppins">Return Policy</h2>
                <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
                    <div class="flex items-start mb-4">
                        <div
                            class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">30-Day Return Window</h3>
                            <p class="text-gray-600 font-inter">You have 30 days from the delivery date to return eligible
                                items.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 font-poppins">Eligible Items</h3>
                        <ul class="space-y-2 text-gray-600 font-inter">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Unused products in original condition
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Original packaging with all accessories
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Proof of purchase (order number/receipt)
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 font-poppins">Non-Returnable Items</h3>
                        <ul class="space-y-2 text-gray-600 font-inter">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Opened software or digital products
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Personal care items (if opened)
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Custom or personalized items
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Refund Process -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-poppins">Refund Process</h2>
                <div class="space-y-8">
                    <div class="flex items-start">
                        <div
                            class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0 font-bold">
                            1</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Initiate Return</h3>
                            <p class="text-gray-600 font-inter">Contact our support team or visit your order history to
                                start a return request.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0 font-bold">
                            2</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Ship Item Back</h3>
                            <p class="text-gray-600 font-inter">Pack the item securely and ship it to our return address.
                                We'll provide a return label if applicable.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0 font-bold">
                            3</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Inspection</h3>
                            <p class="text-gray-600 font-inter">We inspect the returned item upon receipt (typically 2-3
                                business days after delivery).</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0 font-bold">
                            4</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Refund Issued</h3>
                            <p class="text-gray-600 font-inter">Refund is processed within 7-10 business days after
                                approval, to your original payment method.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Return -->
            <div class="bg-gradient-to-r from-primary/5 to-accent/5 rounded-xl p-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">Ready to Start a Return?</h2>
                <p class="text-gray-600 mb-6 font-inter">Have your order number ready and ensure your item meets our return
                    criteria.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                        class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors font-inter">
                        Contact Support
                    </a>
                    <a href="mailto:returns@tycoon.com"
                        class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-800 font-semibold rounded-lg border border-gray-300 transition-colors font-inter">
                        Email Returns Team
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
