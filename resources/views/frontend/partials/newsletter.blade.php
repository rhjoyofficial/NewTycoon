<!-- Newsletter Section - Enhanced Design -->
<div class="max-w-8xl mx-auto mt-10 relative overflow-hidden bg-gradient-to-br from-[#9f1d1f] via-[#7a2f1a] to-[#5a2c16] placeholder:rounded-3xl p-8 md:p-12 mb-12 shadow-2xl border border-white/10"
    data-aos="fade-up">
    <!-- Decorative blurred orbs (pure Tailwind) -->
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-accent/20 rounded-full blur-3xl"></div>

    <div class="max-w-4xl mx-auto text-center relative z-10">
        <h3 class="text-3xl md:text-4xl font-bold text-white mb-4 font-poppins tracking-tight">
            {{ __('newsletter.subscribe-title') }}
        </h3>
        <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto font-cambay leading-relaxed">
            {{ __('newsletter.subscribe') }}
        </p>

        <!-- Success/Error Messages (enhanced with icons) -->
        <div id="newsletter-message" class="hidden mb-6">
            <div id="newsletter-success"
                class="hidden bg-green-500/10 border border-green-500/30 text-green-200 px-5 py-4 rounded-2xl flex items-center justify-center gap-3 backdrop-blur-sm">
                <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span id="success-text" class="text-sm font-medium"></span>
            </div>
            <div id="newsletter-error"
                class="hidden bg-red-500/10 border border-red-500/30 text-red-200 px-5 py-4 rounded-2xl flex items-center justify-center gap-3 backdrop-blur-sm">
                <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span id="error-text" class="text-sm font-medium"></span>
            </div>
        </div>

        <form id="newsletter-form" class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto font-poppins">
            @csrf
            <input type="email" name="email" id="newsletter-email" placeholder="{{ __('newsletter.enter-email') }}"
                autocomplete="email"
                class="flex-1 px-6 py-4 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50
                       focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent
                       transition-all duration-300 font-poppins text-base"
                value="{{ auth()->check() ? auth()->user()->email : '' }}" required />
            <button type="submit" id="subscribe-btn"
                class="px-8 py-4 bg-white text-primary font-semibold rounded-2xl shadow-lg hover:shadow-xl
                       hover:bg-white/90 transition-all duration-300 whitespace-nowrap text-base
                       disabled:opacity-50 disabled:cursor-not-allowed">
                {{ __('newsletter.subscribe-button') }}
            </button>
        </form>

        <!-- Loading Spinner (enhanced) -->
        <div id="newsletter-loading" class="hidden mt-6">
            <div class="inline-flex items-center gap-3 text-white/80">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-sm font-medium">Subscribing...</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newsletterForm = document.getElementById('newsletter-form');
            const newsletterEmail = document.getElementById('newsletter-email');
            const subscribeBtn = document.getElementById('subscribe-btn');
            const newsletterLoading = document.getElementById('newsletter-loading');
            const newsletterMessage = document.getElementById('newsletter-message');
            const successMessage = document.getElementById('newsletter-success');
            const errorMessage = document.getElementById('newsletter-error');
            const successText = document.getElementById('success-text');
            const errorText = document.getElementById('error-text');

            // Hide all messages initially
            function hideAllMessages() {
                newsletterMessage.classList.add('hidden');
                successMessage.classList.add('hidden');
                errorMessage.classList.add('hidden');
            }

            // Show success message
            function showSuccess(message) {
                hideAllMessages();
                successText.textContent = message;
                successMessage.classList.remove('hidden');
                newsletterMessage.classList.remove('hidden');

                // Clear form
                newsletterEmail.value = '';

                // Hide message after 3 seconds
                setTimeout(() => {
                    hideAllMessages();
                }, 3000);
            }

            // Show error message
            function showError(message) {
                hideAllMessages();
                errorText.textContent = message;
                errorMessage.classList.remove('hidden');
                newsletterMessage.classList.remove('hidden');

                // Hide message after 3 seconds
                setTimeout(() => {
                    hideAllMessages();
                }, 3000);
            }

            // Handle form submission
            newsletterForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const email = newsletterEmail.value.trim();

                if (!email) {
                    showError('Please enter your email address.');
                    return;
                }

                // Email validation regex
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    showError('Please enter a valid email address.');
                    return;
                }

                // Show loading, disable button
                newsletterLoading.classList.remove('hidden');
                subscribeBtn.disabled = true;
                subscribeBtn.innerHTML = 'Subscribing...';

                try {
                    const response = await fetch('{{ route('newsletter.subscribe') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                                .value,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        showSuccess(data.message);
                    } else {
                        showError(data.message);
                    }

                } catch (error) {
                    console.error('Error:', error);
                    showError('Something went wrong. Please try again.');
                } finally {
                    // Hide loading, enable button
                    newsletterLoading.classList.add('hidden');
                    subscribeBtn.disabled = false;
                    subscribeBtn.innerHTML = 'Subscribe';
                }
            });
        });
    </script>

    <style>
        #subscribe-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
