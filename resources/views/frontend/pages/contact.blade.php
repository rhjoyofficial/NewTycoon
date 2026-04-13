@extends('frontend.layouts.app')

@section('title', 'Customer Support')
@section('description', 'Get help with your orders, products, and account')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">How can we help you?</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto font-inter">We're here to help with any questions or issues you
                might have</p>
        </div>

        <!-- Search Support -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="relative">
                <input type="text" placeholder="Search for help topics..."
                    class="w-full px-6 py-4 pl-12 text-gray-700 bg-white border-2 border-gray-200 rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all font-inter">
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Quick Help Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <div
                class="bg-white p-6 rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all group">
                <div
                    class="w-12 h-12 bg-primary-light text-primary rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Track Order</h3>
                <p class="text-gray-600 text-sm font-inter">Check your order status and delivery updates</p>
            </div>

            <div
                class="bg-white p-6 rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all group">
                <div
                    class="w-12 h-12 bg-primary-light text-primary rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Returns & Refunds</h3>
                <p class="text-gray-600 text-sm font-inter">Start a return or check refund status</p>
            </div>

            <div
                class="bg-white p-6 rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all group">
                <div
                    class="w-12 h-12 bg-primary-light text-primary rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Account Help</h3>
                <p class="text-gray-600 text-sm font-inter">Password reset and account settings</p>
            </div>

            <div
                class="bg-white p-6 rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all group">
                <div
                    class="w-12 h-12 bg-primary-light text-primary rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Product Help</h3>
                <p class="text-gray-600 text-sm font-inter">Technical support and product guides</p>
            </div>
        </div>

        <!-- Contact Options -->
        <div class="bg-gradient-to-r from-primary/5 to-accent/5 rounded-2xl p-8 mb-16">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center font-poppins">Contact Our Support Team</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl text-center">
                        <div
                            class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-poppins">Call Us</h3>
                        <p class="text-gray-600 mb-2 font-inter">Available 24/7</p>
                        <a href="tel:+880XXXXXXXXXX"
                            class="text-primary hover:text-primary-dark font-semibold text-lg font-inter">+880
                            XXX-XXXXXXX</a>
                    </div>

                    <div class="bg-white p-6 rounded-xl text-center">
                        <div
                            class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-poppins">Email Us</h3>
                        <p class="text-gray-600 mb-2 font-inter">Response within 24 hours</p>
                        <a href="mailto:support@tycoon.com"
                            class="text-primary hover:text-primary-dark font-semibold text-lg font-inter">support@tycoon.com</a>
                    </div>

                    <div class="bg-white p-6 rounded-xl text-center">
                        <div
                            class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-poppins">Live Chat</h3>
                        <p class="text-gray-600 mb-2 font-inter">Chat with us online</p>
                        <button
                            class="px-6 py-2 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors font-inter">Start
                            Chat</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Preview -->
        <div class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-900 font-poppins">Frequently Asked Questions</h2>
                <a href="{{ route('faq') }}"
                    class="text-primary hover:text-primary-dark font-semibold flex items-center font-inter">
                    View all FAQs
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ([['q' => 'How long does shipping take?', 'a' => 'Standard shipping takes 3-5 business days. Express shipping is available for 1-2 day delivery.'], ['q' => 'What is your return policy?', 'a' => 'We offer a 30-day return policy for unused items in original packaging.'], ['q' => 'Do you ship internationally?', 'a' => 'Yes, we ship to over 50 countries worldwide.'], ['q' => 'How can I track my order?', 'a' => 'Use the tracking link in your confirmation email or visit our Track Order page.']] as $faq)
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 font-poppins">{{ $faq['q'] }}</h3>
                        <p class="text-gray-600 font-inter">{{ $faq['a'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
