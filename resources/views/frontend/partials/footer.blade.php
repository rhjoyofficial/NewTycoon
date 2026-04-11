<!-- resources/views/partials/footer.blade.php -->
<footer class="bg-gray-900 text-white pt-16 pb-10 px-6 md:px-8 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -bottom-32 -right-32 w-64 h-64 rounded-full bg-primary/10 blur-3xl"></div>
        <div class="absolute -bottom-48 left-1/4 w-52 h-52 rounded-full bg-accent/10 blur-3xl"></div>
        <div class="absolute top-1/4 -left-20 w-40 h-40 rounded-full bg-gray-800 blur-3xl"></div>
    </div>

    <div class="max-w-8xl mx-auto relative z-10">
        <!-- Top Footer Section - Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-16">
            <!-- Brand Section - Centered -->
            <div class="lg:col-span-4 flex justify-center lg:justify-start" data-aos="fade-up">
                <div class="p-2 max-w-sm w-full">
                    <!-- Logo -->
                    <div class="text-center lg:text-left">
                        <a href="{{ url('/') }}" aria-label="Home" class="inline-block"
                            title="Tycoon Hi-Tech Park">
                            <img src="{{ asset('images/wh-logo.png') }}" alt="BK Logo" class="h-6 md:h-8 w-auto">
                        </a>
                    </div>

                    <!-- Description -->
                    {{-- <p class="mt-6 text-gray-300 leading-relaxed text-sm text-justify lg:text-justify">
                        {{ $footerData['brand']['description'] }}
                    </p> --}}
                    <p class="mt-2 text-gray-400 text-sm text-center lg:text-left">
                        {{ $footerData['brand']['address'] }}
                    </p>
                    <!-- Hotline & Emails -->
                    <div class="mt-4 space-y-2 text-sm text-gray-300 text-center lg:text-left">

                        <!-- Hotline -->
                        <div class="flex items-center justify-center lg:justify-start gap-2">
                            <i class="fas fa-phone-alt text-primary text-xs"></i>
                            <a href="tel:{{ $footerData['contact_info']['hotline_1'] ?? '+8801xxxxxxxxx' }}"
                                class="hover:text-white transition">
                                {{ $footerData['contact_info']['hotline_1'] ?? '+8801xxxxxxxxx' }}
                            </a>
                            <span class="text-gray-500">|</span>
                            <a href="tel:{{ $footerData['contact_info']['hotline_2'] ?? '+8801xxxxxxxx' }}"
                                class="hover:text-white transition">
                                {{ $footerData['contact_info']['hotline_2'] ?? '+8801xxxxxxxxx' }}
                            </a>
                        </div>

                        <!-- Emails -->
                        <div class="flex items-center justify-center lg:justify-start gap-2">
                            <i class="fas fa-envelope text-primary text-xs"></i>
                            <a href="mailto:{{ $footerData['contact_info']['email_1'] ?? 'xxx@example.com' }}"
                                class="hover:text-white transition">
                                {{ $footerData['contact_info']['email_1'] ?? 'xxx@example.com' }}
                            </a>
                            <span class="text-gray-500">|</span>
                            <a href="mailto:{{ $footerData['contact_info']['email_2'] ?? 'xxx@example.com' }}"
                                class="hover:text-white transition">
                                {{ $footerData['contact_info']['email_2'] ?? 'xxx@example.com' }}
                            </a>
                        </div>

                    </div>

                    <!-- Social Media -->
                    <div class="flex justify-center lg:justify-start gap-3 mt-6">
                        <a href="{{ $footerData['social_links']['facebook'] ?? '#' }}"
                            class="social-icon w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group border border-white/10">
                            <i class="fab fa-facebook-f text-gray-400 group-hover:text-white text-sm"></i>
                        </a>
                        <a href="{{ $footerData['social_links']['twitter'] ?? '#' }}"
                            class="social-icon w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group border border-white/10">
                            <i class="fab fa-twitter text-gray-400 group-hover:text-white text-sm"></i>
                        </a>
                        <a href="{{ $footerData['social_links']['instagram'] ?? '#' }}"
                            class="social-icon w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group border border-white/10">
                            <i class="fab fa-instagram text-gray-400 group-hover:text-white text-sm"></i>
                        </a>
                        <a href="{{ $footerData['social_links']['linkedin'] ?? '#' }}"
                            class="social-icon w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group border border-white/10">
                            <i class="fab fa-linkedin-in text-gray-400 group-hover:text-white text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Links Sections -->
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($footerData['columns'] as $index => $column)
                    <div class="flex-1" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <h3 class="text-xl font-semibold mb-6 text-white font-cambay">
                            {{ $column['title'] }}
                        </h3>
                        <ul class="space-y-3">
                            @foreach ($column['links'] as $link)
                                <li class="font-poppins">
                                    <a href="{{ url($link['url'] ?? '#') }}"
                                        class="group flex items-center text-gray-300 hover:text-white transition-all duration-300 ">
                                        <span
                                            class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></span>
                                        <span
                                            class="text-base hover:text-primary transition-colors">{{ $link['title'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Divider -->
        <div class="border-b border-gray-700/50 my-8" data-aos="fade-right"></div>

        <!-- Bottom Section -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pt-6 font-cambay">
            <!-- Copyright -->
            <p class="text-gray-400 text-sm order-2 md:order-1" data-aos="fade-right">
                Copyright © Tycoonbd.com, All Right Reserved © {{ date('Y') }}
            </p>

            <!-- Payment Methods -->
            <div class="flex flex-col items-center gap-4 order-1 md:order-2" data-aos="fade-up">
                <span class="text-gray-400 text-sm">We accept:</span>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach ($footerData['payments'] as $payment)
                        <div
                            class="payment-icon bg-white/5 p-2 rounded-lg hover:bg-white/10 transition-all duration-300 border border-white/10">
                            <img src="{{ $payment }}"
                                class="h-6 object-contain filter brightness-0 invert opacity-80 hover:opacity-100 transition-opacity" />
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</footer>
