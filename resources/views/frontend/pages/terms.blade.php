@extends('frontend.layouts.app')

@section('title', 'Terms of Service')
@section('description', 'Terms and conditions for using Tycoon services')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">Terms of Service</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto font-inter">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Introduction -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">1. Introduction</h2>
                <p class="text-gray-600 mb-4 font-inter">Welcome to Tycoon. These Terms of Service govern your use of our
                    website located at tycoon.com and our services. By accessing or using our services, you agree to be
                    bound by these Terms.</p>
            </div>

            <!-- Account Terms -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">2. Account Registration</h2>
                <p class="text-gray-600 mb-4 font-inter">To access certain features, you must create an account. You agree
                    to:</p>
                <ul class="list-disc pl-6 text-gray-600 space-y-2 font-inter">
                    <li>Provide accurate and complete information</li>
                    <li>Maintain the security of your password</li>
                    <li>Accept responsibility for all activities under your account</li>
                    <li>Not create accounts for unauthorized purposes</li>
                </ul>
            </div>

            <!-- Orders and Payments -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">3. Orders and Payments</h2>
                <div class="space-y-4">
                    <p class="text-gray-600 font-inter">All orders are subject to product availability and our acceptance.
                        We reserve the right to refuse or cancel any order for any reason.</p>
                    <p class="text-gray-600 font-inter">Prices are shown in Bangladeshi Taka (<span
                            class="font-bengali">৳</span>) and are subject to change
                        without notice. We accept various payment methods as indicated during checkout.</p>
                </div>
            </div>

            <!-- Shipping and Delivery -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">4. Shipping and Delivery</h2>
                <div class="space-y-4">
                    <p class="text-gray-600 font-inter">Shipping times are estimates and not guaranteed. We are not
                        responsible for delays caused by carriers or customs.</p>
                    <p class="text-gray-600 font-inter">Risk of loss passes to you upon delivery. You must inspect products
                        upon delivery and report any damages immediately.</p>
                </div>
            </div>

            <!-- Returns and Refunds -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">5. Returns and Refunds</h2>
                <div class="space-y-4">
                    <p class="text-gray-600 font-inter">Our return policy is governed by our separate <a
                            href="{{ route('returns') }}" class="text-primary hover:text-primary-dark font-medium">Returns
                            Policy</a>.</p>
                    <p class="text-gray-600 font-inter">Refunds are processed within 7-10 business days after we receive the
                        returned item.</p>
                </div>
            </div>

            <!-- Intellectual Property -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">6. Intellectual Property</h2>
                <div class="space-y-4">
                    <p class="text-gray-600 font-inter">All content on our website, including text, graphics, logos, and
                        images, is our property or licensed to us and is protected by copyright laws.</p>
                    <p class="text-gray-600 font-inter">You may not reproduce, distribute, or create derivative works
                        without our express written permission.</p>
                </div>
            </div>

            <!-- Limitation of Liability -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">7. Limitation of Liability</h2>
                <p class="text-gray-600 font-inter">To the maximum extent permitted by law, Tycoon shall not be liable for
                    any indirect, incidental, special, consequential, or punitive damages resulting from your use of our
                    services.</p>
            </div>

            <!-- Changes to Terms -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">8. Changes to Terms</h2>
                <p class="text-gray-600 font-inter">We reserve the right to modify these Terms at any time. We will notify
                    users of material changes via email or website notice.</p>
            </div>

            <!-- Governing Law -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">9. Governing Law</h2>
                <p class="text-gray-600 font-inter">These Terms shall be governed by and construed in accordance with the
                    laws of Bangladesh, without regard to its conflict of law provisions.</p>
            </div>

            <!-- Contact -->
            <div class="bg-primary/5 rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-poppins">Contact Us</h2>
                <p class="text-gray-600 mb-4 font-inter">If you have any questions about these Terms, please contact us:</p>
                <div class="space-y-2 font-inter">
                    <p class="text-gray-600">Email: <a href="mailto:legal@tycoon.com"
                            class="text-primary hover:text-primary-dark font-medium">legal@tycoon.com</a></p>
                    <p class="text-gray-600">Address: Tycoon Hi-Tech Park, Dhaka, Bangladesh</p>
                </div>
            </div>
        </div>
    </div>
@endsection
