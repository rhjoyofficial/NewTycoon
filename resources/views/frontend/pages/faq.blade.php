@extends('frontend.layouts.app')

@section('title', 'Frequently Asked Questions')
@section('description', 'Find answers to common questions about Tycoon')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">Frequently Asked Questions</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto font-inter">Find quick answers to common questions about our
                products and services</p>
        </div>

        <!-- Search FAQ -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="relative">
                <input type="text" placeholder="Search FAQs..."
                    class="w-full px-6 py-4 pl-12 text-gray-700 bg-white border-2 border-gray-200 rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all font-inter">
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- FAQ Categories -->
        <div class="mb-16">
            <div class="flex flex-wrap gap-3 justify-center mb-8">
                <button
                    class="px-6 py-2 bg-primary text-white font-semibold rounded-full transition-colors font-inter">All</button>
                <button
                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-full transition-colors font-inter">Orders</button>
                <button
                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-full transition-colors font-inter">Shipping</button>
                <button
                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-full transition-colors font-inter">Returns</button>
                <button
                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-full transition-colors font-inter">Products</button>
                <button
                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-full transition-colors font-inter">Account</button>
                <button
                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-full transition-colors font-inter">Payment</button>
            </div>

            <!-- FAQ Accordion -->
            <div class="max-w-4xl mx-auto space-y-4">
                <!-- Order FAQs -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <button
                        class="faq-toggle w-full px-6 py-4 bg-gray-50 hover:bg-gray-100 text-left flex items-center justify-between transition-colors">
                        <h3 class="text-lg font-bold text-gray-900 font-poppins">Order Questions</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-6 py-4 bg-white hidden">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">How do I place an order?</h4>
                                <p class="text-gray-600 font-inter">Browse products, add to cart, and proceed to checkout.
                                    Follow the steps to enter shipping and payment information.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">Can I modify or cancel my
                                    order?</h4>
                                <p class="text-gray-600 font-inter">You can modify or cancel your order within 1 hour of
                                    placement. After that, contact our support team immediately.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">How do I track my order?</h4>
                                <p class="text-gray-600 font-inter">Use the tracking link in your confirmation email or
                                    visit the Track Order page with your order number.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping FAQs -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <button
                        class="faq-toggle w-full px-6 py-4 bg-gray-50 hover:bg-gray-100 text-left flex items-center justify-between transition-colors">
                        <h3 class="text-lg font-bold text-gray-900 font-poppins">Shipping & Delivery</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-6 py-4 bg-white hidden">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">What are your shipping
                                    options?</h4>
                                <p class="text-gray-600 font-inter">We offer standard (3-5 business days) and express (1-2
                                    business days) shipping options.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">Do you ship internationally?
                                </h4>
                                <p class="text-gray-600 font-inter">Yes, we ship to over 50 countries worldwide. Shipping
                                    times vary by destination.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">How much does shipping cost?
                                </h4>
                                <p class="text-gray-600 font-inter">Shipping costs are calculated at checkout based on
                                    destination, weight, and shipping method.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Returns FAQs -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <button
                        class="faq-toggle w-full px-6 py-4 bg-gray-50 hover:bg-gray-100 text-left flex items-center justify-between transition-colors">
                        <h3 class="text-lg font-bold text-gray-900 font-poppins">Returns & Refunds</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-6 py-4 bg-white hidden">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">What is your return policy?
                                </h4>
                                <p class="text-gray-600 font-inter">We offer a 30-day return policy for unused items in
                                    original packaging with all accessories.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">How do I start a return?</h4>
                                <p class="text-gray-600 font-inter">Visit our Returns page or contact customer support to
                                    initiate a return request.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">How long do refunds take?
                                </h4>
                                <p class="text-gray-600 font-inter">Refunds are processed within 7-10 business days after we
                                    receive and inspect the returned item.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product FAQs -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <button
                        class="faq-toggle w-full px-6 py-4 bg-gray-50 hover:bg-gray-100 text-left flex items-center justify-between transition-colors">
                        <h3 class="text-lg font-bold text-gray-900 font-poppins">Product Questions</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-6 py-4 bg-white hidden">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">Are your products authentic?
                                </h4>
                                <p class="text-gray-600 font-inter">Yes, all our products are 100% authentic and sourced
                                    directly from authorized suppliers.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">Do you offer warranties?</h4>
                                <p class="text-gray-600 font-inter">Most products come with manufacturer warranties. Check
                                    individual product pages for warranty details.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">Can I get product
                                    specifications?</h4>
                                <p class="text-gray-600 font-inter">Detailed specifications are available on each product
                                    page under the "Specifications" tab.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment FAQs -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <button
                        class="faq-toggle w-full px-6 py-4 bg-gray-50 hover:bg-gray-100 text-left flex items-center justify-between transition-colors">
                        <h3 class="text-lg font-bold text-gray-900 font-poppins">Payment Methods</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-6 py-4 bg-white hidden">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">What payment methods do you
                                    accept?</h4>
                                <p class="text-gray-600 font-inter">We accept credit/debit cards, mobile banking, and cash
                                    on delivery (where available).</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">Is my payment information
                                    secure?</h4>
                                <p class="text-gray-600 font-inter">Yes, we use SSL encryption and PCI-compliant payment
                                    processors to ensure your information is secure.</p>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-900 mb-2 font-poppins">Do you store my payment
                                    details?</h4>
                                <p class="text-gray-600 font-inter">We do not store your complete payment details. They are
                                    securely processed by our payment partners.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Still Have Questions -->
        <div class="bg-gradient-to-r from-primary/5 to-accent/5 rounded-2xl p-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4 font-poppins">Still have questions?</h2>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto font-inter">Can't find the answer you're looking for? Our
                support team is here to help.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}"
                    class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors font-inter">
                    Contact Support
                </a>
                <a href="tel:+880XXXXXXXXXX"
                    class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-800 font-semibold rounded-lg border border-gray-300 transition-colors font-inter">
                    Call Us Now
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // FAQ accordion functionality
                const faqToggles = document.querySelectorAll('.faq-toggle');

                faqToggles.forEach(toggle => {
                    toggle.addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const icon = this.querySelector('svg');

                        // Toggle content visibility
                        content.classList.toggle('hidden');

                        // Rotate icon
                        icon.classList.toggle('rotate-180');

                        // Close other open FAQs (optional)
                        faqToggles.forEach(otherToggle => {
                            if (otherToggle !== this) {
                                const otherContent = otherToggle.nextElementSibling;
                                const otherIcon = otherToggle.querySelector('svg');
                                if (!otherContent.classList.contains('hidden')) {
                                    otherContent.classList.add('hidden');
                                    otherIcon.classList.remove('rotate-180');
                                }
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
