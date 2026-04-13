@extends('frontend.layouts.app')

@section('title', 'Privacy Policy')
@section('description', 'How we collect, use, and protect your personal information')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">Privacy Policy</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto font-inter">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Introduction -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">1. Introduction</h2>
                <p class="text-gray-600 mb-4 font-inter">Tycoon ("we," "our," or "us") is committed to protecting your
                    privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when
                    you visit our website or make a purchase.</p>
            </div>

            <!-- Information We Collect -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">2. Information We Collect</h2>
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-gray-900 font-poppins">Personal Information</h3>
                    <p class="text-gray-600 font-inter">We collect personal information that you voluntarily provide:</p>
                    <ul class="list-disc pl-6 text-gray-600 space-y-2 font-inter">
                        <li>Name and contact details (email, phone, address)</li>
                        <li>Payment information (processed securely by payment providers)</li>
                        <li>Account credentials</li>
                        <li>Communication preferences</li>
                    </ul>

                    <h3 class="text-xl font-bold text-gray-900 mt-6 font-poppins">Automatically Collected Information</h3>
                    <ul class="list-disc pl-6 text-gray-600 space-y-2 font-inter">
                        <li>IP address and device information</li>
                        <li>Browser type and version</li>
                        <li>Pages visited and time spent</li>
                        <li>Referring website</li>
                    </ul>
                </div>
            </div>

            <!-- How We Use Your Information -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">3. How We Use Your Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Order Processing</h3>
                        <p class="text-gray-600 text-sm font-inter">Process and fulfill your orders, send order
                            confirmations, and provide customer support</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-poppins">Improve Services</h3>
                        <p class="text-gray-600 text-sm font-inter">Analyze usage patterns to improve our website, products,
                            and customer experience</p>
                    </div>
                </div>
            </div>

            <!-- Information Sharing -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">4. Information Sharing</h2>
                <p class="text-gray-600 mb-4 font-inter">We do not sell your personal information. We may share information
                    with:</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-bold text-gray-900 mb-2 font-poppins">Service Providers</h4>
                        <p class="text-gray-600 text-sm font-inter">Payment processors, shipping carriers, and IT service
                            providers</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-bold text-gray-900 mb-2 font-poppins">Legal Requirements</h4>
                        <p class="text-gray-600 text-sm font-inter">When required by law or to protect our rights</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-bold text-gray-900 mb-2 font-poppins">Business Transfers</h4>
                        <p class="text-gray-600 text-sm font-inter">In connection with a merger, acquisition, or asset sale
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Security -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">5. Data Security</h2>
                <div class="space-y-4">
                    <p class="text-gray-600 font-inter">We implement appropriate technical and organizational security
                        measures to protect your personal information:</p>
                    <div class="flex flex-wrap gap-3">
                        <span class="px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full font-inter">SSL
                            Encryption</span>
                        <span
                            class="px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full font-inter">Secure
                            Servers</span>
                        <span
                            class="px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full font-inter">Access
                            Controls</span>
                        <span
                            class="px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full font-inter">Regular
                            Audits</span>
                    </div>
                </div>
            </div>

            <!-- Your Rights -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">6. Your Rights</h2>
                <div class="space-y-4">
                    <p class="text-gray-600 font-inter">You have the right to:</p>
                    <ul class="list-disc pl-6 text-gray-600 space-y-2 font-inter">
                        <li>Access your personal information</li>
                        <li>Correct inaccurate information</li>
                        <li>Request deletion of your information</li>
                        <li>Object to processing of your information</li>
                        <li>Data portability</li>
                        <li>Withdraw consent</li>
                    </ul>
                </div>
            </div>

            <!-- Cookies -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">7. Cookies</h2>
                <p class="text-gray-600 mb-4 font-inter">We use cookies and similar technologies to enhance your browsing
                    experience. You can control cookies through your browser settings.</p>
            </div>

            <!-- Changes to Policy -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">8. Changes to This Policy</h2>
                <p class="text-gray-600 font-inter">We may update this Privacy Policy periodically. We will notify you of
                    significant changes by posting the new policy on our website.</p>
            </div>

            <!-- Contact -->
            <div class="bg-primary/5 rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">Contact Us</h2>
                <p class="text-gray-600 mb-4 font-inter">If you have questions about this Privacy Policy or our privacy
                    practices:</p>
                <div class="space-y-2 font-inter">
                    <p class="text-gray-600">Email: <a href="mailto:privacy@tycoon.com"
                            class="text-primary hover:text-primary-dark font-medium">privacy@tycoon.com</a></p>
                    <p class="text-gray-600">Address: Tycoon Hi-Tech Park, Dhaka, Bangladesh</p>
                    <p class="text-gray-600">Phone: +880 XXX-XXXXXXX</p>
                </div>
            </div>
        </div>
    </div>
@endsection
