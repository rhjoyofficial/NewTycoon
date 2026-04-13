{{-- resources/views/components/offer-section.blade.php --}}
@props(['offer'])

@php
    // Get offer data from service
    $offerService = app(App\Services\Offer\OfferService::class);
    $offerData = $offerService->getOfferWithProducts($offer);

    $offerInfo = $offerData['data'];
    $offerProducts = $offerData['products'];

    // Increment view count
    $offerService->recordView($offer);
@endphp

<!-- Offers Section -->
<section class="relative w-full py-12 md:py-16 overflow-hidden px-4 offer-section" data-offer-id="{{ $offer->id }}"
    data-offer-slug="{{ $offer->slug }}">
    {{-- Top Blur/Shadow Effect for smooth transition from previous section --}}
    <div class="absolute top-0 left-0 right-0 h-10 bg-gradient-to-b from-gray-50 via-cyan-400/20 to-transparent z-20">
    </div>
    <div class="absolute -bottom-8 left-0 right-0 h-12 bg-gradient-to-b from-cyan-600/20 via-white to-transparent z-20">
    </div>

    {{-- Full Width Background Container --}}
    <div class="absolute inset-0 w-full h-full overflow-hidden">
        <div class="relative w-full h-full">
            @if ($offerInfo['background_type'] === 'video' && $offerInfo['background_video'])
                <video autoplay loop muted playsinline class="w-full h-full object-cover">
                    <source src="{{ $offerInfo['background_video'] }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @elseif($offerInfo['background_type'] === 'color' && $offerInfo['background_color'])
                <div class="w-full h-full" style="background-color: {{ $offerInfo['background_color'] }}"></div>
            @else
                <img src="{{ $offerInfo['background_image'] }}" class="w-full h-full object-cover"
                    alt="{{ $offerInfo['title'] }} Background" loading="lazy"
                    onerror="this.src='{{ asset('images/offers/default-bg.jpg') }}'">
            @endif
        </div>
    </div>

    {{-- Gradient Overlay for better readability --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/40 to-black/20"></div>

    {{-- CONTENT constrained to 8xl --}}
    <div class="relative max-w-8xl mx-auto overflow-hidden">
        {{-- TOP BANNER AREA --}}
        <div class="w-full relative mb-4 overflow-hidden rounded-xl">
            {{-- Background Image (Full Width + Full Height) --}}
            @if ($offerInfo['main_banner_image'])
                <div class="absolute inset-0">
                    <img src="{{ $offerInfo['main_banner_image'] }}" alt="{{ $offerInfo['title'] }} Banner"
                        class="w-full h-full object-cover" loading="lazy"
                        onerror="this.src='{{ asset('images/offers/default-banner.jpg') }}'">
                </div>
            @endif

            {{-- Content on top of the image --}}
            <div class="relative z-10 p-4 md:p-6">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                    {{-- Left: Title & Info --}}
                    <div class="text-center lg:text-left">
                        <h2 class="text-white text-2xl md:text-3xl font-bold font-poppins mb-2">
                            {{ $offerInfo['title'] }}
                        </h2>
                        @if ($offerInfo['subtitle'])
                            <p class="text-white/90 text-base md:text-lg font-cambay max-w-2xl">
                                {{ $offerInfo['subtitle'] }}
                            </p>
                        @endif
                    </div>

                    {{-- Right: Timer --}}
                    @if ($offerInfo['timer_enabled'] && $offerInfo['timer_end_date'])
                        <div class="flex-shrink-0">
                            <div class="backdrop-blur-md bg-white/10 border border-white/20 px-6 py-3 rounded-xl">
                                <div class="text-xs tracking-wide text-white/80 font-cambay mb-1 text-center">
                                    OFFER ENDS IN
                                </div>

                                <div id="offer-timer-{{ $offer->id }}"
                                    class="flex items-center justify-center gap-3 text-white font-poppins text-lg md:text-xl"
                                    data-end-date="{{ $offerInfo['timer_end_date'] }}">

                                    {{-- Days --}}
                                    <div class="flex items-center gap-1">
                                        <span class="timer-days font-bold">00</span>
                                        <span class="text-[11px] opacity-70">d</span>
                                    </div>

                                    {{-- Divider --}}
                                    <div class="w-1 h-1 bg-white/40 rounded-full"></div>

                                    {{-- Hours --}}
                                    <div class="flex items-center gap-1">
                                        <span class="timer-hours font-bold">00</span>
                                        <span class="text-[11px] opacity-70">h</span>
                                    </div>

                                    <div class="w-1 h-1 bg-white/40 rounded-full"></div>

                                    {{-- Minutes --}}
                                    <div class="flex items-center gap-1">
                                        <span class="timer-minutes font-bold">00</span>
                                        <span class="text-[11px] opacity-70">m</span>
                                    </div>

                                    <div class="w-1 h-1 bg-white/40 rounded-full"></div>

                                    {{-- Seconds --}}
                                    <div class="flex items-center gap-1">
                                        <span class="timer-seconds font-bold">00</span>
                                        <span class="text-[11px] opacity-70">s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Force minimum banner height --}}
                <div class="h-[200px] md:h-[250px]"></div>
            </div>
        </div>

        {{-- PRODUCT SLIDER SECTION --}}
        @if (count($offerProducts) > 0)
            <div class="mt-4">
                {{-- Header Row --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-4">
                    <div>
                        <h3 class="text-white text-2xl md:text-3xl font-bold font-poppins">
                            Special Offer Products
                        </h3>
                        <p class="text-white/80 text-sm md:text-base font-cambay mt-1">
                            {{ count($offerProducts) }} products on discount
                        </p>
                    </div>

                    <a href="{{ $offerInfo['view_all_link'] }}"
                        class="inline-flex items-center px-5 py-2.5 bg-white text-gray-900 font-semibold rounded-md hover:bg-gray-100 transition-colors"
                        onclick="recordOfferClick({{ $offer->id }})">
                        {{ $offerInfo['view_all_text'] }}
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                {{-- Swiper Slider --}}
                <div class="swiper offer-products-swiper-{{ $offer->id }} relative pb-10">
                    <div class="swiper-wrapper">
                        @foreach ($offerProducts as $product)
                            <div class="swiper-slide !h-auto">
                                <x-offer-product-card :product="$product" :offer="$offer" />
                            </div>
                        @endforeach
                    </div>

                    @if (count($offerProducts) > 1)
                        <div
                            class="swiper-button-next !text-white !bg-black/30 backdrop-blur-sm !w-10 !h-10 md:!w-12 md:!h-12 !rounded-full after:!text-lg hover:!bg-black/50">
                        </div>
                        <div
                            class="swiper-button-prev !text-white !bg-black/30 backdrop-blur-sm !w-10 !h-10 md:!w-12 md:!h-12 !rounded-full after:!text-lg hover:!bg-black/50">
                        </div>
                    @endif
                </div>
            </div>
        @else
            {{-- No Products Message --}}
            <div class="text-center py-12 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20">
                <div class="text-5xl mb-4">😔</div>
                <h3 class="text-white text-xl font-semibold mb-2">No Offers Available</h3>
                <p class="text-white/80">Check back later for amazing deals!</p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
    <script>
        // Initialize Swiper for this offer
        document.addEventListener('DOMContentLoaded', function() {
            const swiperElement = document.querySelector('.offer-products-swiper-{{ $offer->id }}');
            if (swiperElement) {
                const productCount = {{ count($offerProducts) }};
                const swiperConfig = {
                    slidesPerView: 1.3,
                    spaceBetween: 16,
                    loop: productCount > 1,
                    grabCursor: true,
                    speed: 500,
                    breakpoints: {
                        480: {
                            slidesPerView: Math.min(2.2, productCount),
                            spaceBetween: 16
                        },
                        640: {
                            slidesPerView: Math.min(2.5, productCount),
                            spaceBetween: 18
                        },
                        768: {
                            slidesPerView: Math.min(3, productCount),
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: Math.min(4, productCount),
                            spaceBetween: 24
                        },
                        1280: {
                            slidesPerView: Math.min(5, productCount),
                            spaceBetween: 24
                        },
                    },
                };

                if (productCount > 1) {
                    swiperConfig.navigation = {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    };
                }

                try {
                    new Swiper(swiperElement, swiperConfig);
                } catch (error) {
                    console.error('Swiper initialization error:', error);
                }
            }

            // Countdown Timer
            const timerElement = document.getElementById('offer-timer-{{ $offer->id }}');
            if (timerElement) {
                const endDateString = timerElement.dataset.endDate;
                if (endDateString) {
                    const endDate = new Date(endDateString).getTime();

                    function updateTimer() {
                        const now = new Date().getTime();
                        const timeLeft = endDate - now;

                        if (timeLeft < 0) {
                            timerElement.innerHTML = '<div class="text-sm font-medium">Offer Expired</div>';
                            return;
                        }

                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        const daysElement = timerElement.querySelector('.timer-days');
                        const hoursElement = timerElement.querySelector('.timer-hours');
                        const minutesElement = timerElement.querySelector('.timer-minutes');
                        const secondsElement = timerElement.querySelector('.timer-seconds');

                        if (daysElement) daysElement.textContent = days.toString().padStart(2, '0');
                        if (hoursElement) hoursElement.textContent = hours.toString().padStart(2, '0');
                        if (minutesElement) minutesElement.textContent = minutes.toString().padStart(2, '0');
                        if (secondsElement) secondsElement.textContent = seconds.toString().padStart(2, '0');
                    }

                    updateTimer();
                    const timerInterval = setInterval(updateTimer, 1000);

                    window.addEventListener('beforeunload', () => {
                        clearInterval(timerInterval);
                    });
                }
            }
        });

        // Record offer click
        function recordOfferClick(offerId) {
            fetch(`/api/offers/${offerId}/click`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).catch(error => console.error('Error recording click:', error));
        }
    </script>
@endpush
