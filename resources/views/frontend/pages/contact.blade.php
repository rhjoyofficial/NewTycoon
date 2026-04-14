@extends('frontend.layouts.app')

@section('title', 'Customer Support')
@section('description', 'Get help with your orders, products, and account')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-12">
        {{-- Hero Section --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">Get in Touch</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto font-inter">We'd love to hear from you. Visit us at our office
                or reach out through any of the channels below.</p>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            {{-- Left Column: Contact Cards --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Visit Us Card --}}
                <div
                    class="bg-gradient-to-br from-primary/10 to-accent/10 rounded-2xl p-8 border border-primary/20 shadow-lg">
                    <div class="w-16 h-16 bg-primary text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">Visit Our Office</h2>
                    <div class="space-y-3 text-gray-700 font-inter">
                        <p class="flex items-start">
                            <span class="font-semibold w-20">Address: </span>
                            <span> &ensp;123 Business Avenue, Gulshan Circle 2, Dhaka 1212, Bangladesh</span>
                        </p>
                        <p class="flex items-start">
                            <span class="font-semibold w-20">Landmark: </span>
                            <span>&ensp; Next to Gulshan Lake Park</span>
                        </p>
                    </div>
                </div>

                {{-- Call Us Card --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-poppins">Call Us</h3>
                    <p class="text-gray-600 mb-2 font-inter">We're available 24/7</p>
                    <a href="tel:+8801712345678"
                        class="text-2xl font-bold text-primary hover:text-primary-dark transition-colors font-inter">+880
                        1712-345678</a>
                    <p class="text-sm text-gray-500 mt-2 font-inter">Toll Free: 16604</p>
                </div>

                {{-- Email Us Card --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-poppins">Email Us</h3>
                    <p class="text-gray-600 mb-2 font-inter">We'll respond within 24 hours</p>
                    <a href="mailto:support@tycoon.com"
                        class="text-lg font-semibold text-primary hover:text-primary-dark transition-colors font-inter">support@tycoon.com</a>
                    <p class="text-sm text-gray-500 mt-2 font-inter">For business inquiries: partners@tycoon.com</p>
                </div>

                {{-- Business Hours Card --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-poppins">Business Hours</h3>
                    <div class="space-y-2 font-inter">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monday - Friday</span>
                            <span class="text-gray-900 font-semibold">9:00 AM - 8:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Saturday</span>
                            <span class="text-gray-900 font-semibold">10:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday</span>
                            <span class="text-gray-900 font-semibold">Closed</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Map and Additional Info --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Google Map Card --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 font-poppins flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Our Location
                        </h3>
                    </div>
                    <div class="aspect-[16/9] w-full">
                        {{-- Replace with your actual Google Maps embed URL --}}
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.755591070966!2d90.36824837463988!3d23.802210453890606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c11be2740a83%3A0x1b14a06dce9ae28d!2sSHELTECH%20RUBYNUR!5e0!3m2!1sen!2sbd!4v1776140314992!5m2!1sen!2sbd"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" class="w-full h-full">
                        </iframe>
                    </div>
                </div>

                {{-- Directions Card --}}
                <div
                    class="bg-gradient-to-r from-primary/5 via-transparent to-accent/5 rounded-2xl p-8 border border-primary/10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">Getting Here</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2 font-poppins flex items-center">
                                <span
                                    class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-sm mr-2">1</span>
                                By Car
                            </h4>
                            <p class="text-gray-600 font-inter ml-8">Free parking available for visitors. Enter from Gulshan
                                Avenue.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2 font-poppins flex items-center">
                                <span
                                    class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-sm mr-2">2</span>
                                By Public Transport
                            </h4>
                            <p class="text-gray-600 font-inter ml-8">5 min walk from Gulshan 2 Bus Stop & Metro Station</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2 font-poppins flex items-center">
                                <span
                                    class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-sm mr-2">3</span>
                                Accessibility
                            </h4>
                            <p class="text-gray-600 font-inter ml-8">Wheelchair accessible entrance and elevator available
                            </p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2 font-poppins flex items-center">
                                <span
                                    class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-sm mr-2">4</span>
                                Security
                            </h4>
                            <p class="text-gray-600 font-inter ml-8">Please bring valid ID for building access</p>
                        </div>
                    </div>
                </div>

                {{-- Social Media Links --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-poppins">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.338 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.338 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.795.646-1.44 1.44-1.44.795 0 1.44.645 1.44 1.44z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ Preview --}}
        <div>
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
                    <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 font-poppins">{{ $faq['q'] }}</h3>
                        <p class="text-gray-600 font-inter">{{ $faq['a'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
