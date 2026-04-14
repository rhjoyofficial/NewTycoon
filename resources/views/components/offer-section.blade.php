{{-- resources/views/components/offer-products.blade.php --}}
@if (isset($offer) && $offer)
    <section class="relative z-10 max-w-8xl mx-auto py-6 md:py-12 px-4">

        {{-- ================== MAIN BANNER ================== --}}
        <div class="relative overflow-hidden mb-6 aspect-[28/5]">

            {{-- Banner Image --}}
            @if ($offer->main_banner_image)
                <img src="{{ $offer->main_banner_url }}" class="absolute inset-0 w-full h-full object-cover aspect-[28/5]"
                    alt="{{ $offer->title }}" />
                @if ($offer->subtitle || $offer->short_description)
                    <div class="absolute inset-0 bg-black/40"></div>
                @endif
            @endif

            {{-- Banner Content --}}
            <div class="relative z-10 p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">

                {{-- Title --}}
                <div class="text-center md:text-left">
                    <h2 class="text-white text-3xl font-bold font-poppins mb-2">
                        {{ $offer->subtitle }}
                    </h2>
                    <p class="text-white/90 text-base md:text-lg font-sans max-w-xl">
                        {{ $offer->short_description }}
                    </p>
                </div>

                {{-- ✅ Timer scoped to offer ID --}}
                @if ($offer->timer_enabled && $offer->timer_end_date)
                    <div class="bg-primary/10 backdrop-blur-md border border-accent/20 rounded-xl px-6 py-4">
                        <div class="text-xs text-white/80 text-center mb-1">OFFER ENDS IN</div>

                        <div id="offer-timer-{{ $offer->id }}" data-end="{{ $offer->timer_end_date }}"
                            class="flex gap-3 text-white font-poppins text-lg">
                            <span class="days">00</span>d
                            <span class="hours">00</span>h
                            <span class="minutes">00</span>m
                            <span class="seconds">00</span>s
                        </div>
                    </div>
                @endif
            </div>

            <div class="h-[120px] md:h-[260px]"></div>
        </div>

        {{-- ================== PRODUCTS SLIDER ================== --}}
        @if ($offerProducts->count())
            <div class="relative">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-medium text-gray-900 leading-tight font-poppins">
                        {{ $offer->title }}
                    </h3>

                    <a href="{{ $offer->formatted_view_all_link }}" target="_self"
                        class="group inline-flex items-center gap-1 text-gray-900 text-sm 2xl:text-base font-inter font-normal tracking-wide transition-colors duration-300 hover:text-primary">
                        <span class="hover:underline">{{ $offer->view_all_text ?? 'View More Products' }}</span>
                        <svg class="w-4 h-4 xl:w-5 xl:h-5 transition-colors duration-300 group-hover:text-primary"
                            fill="currentColor" viewBox="0 0 32 32">
                            <path
                                d="M26.68 3.867H8.175a1 1 0 0 0 0 2h16.544L4.2 26.387A1 1 0 1 0 5.613 27.8l20.52-20.52v16.545a1 1 0 0 0 2 0V5.321a1.456 1.456 0 0 0-1.453-1.454"
                                data-name="Layer 2" />
                        </svg>
                    </a>
                </div>

                {{-- ✅ Swiper wrapper needs position:relative for arrow positioning --}}
                <div class="relative">

                    {{-- ✅ Swiper element scoped to offer ID --}}
                    <div class="swiper offer-products-swiper-{{ $offer->id }} pb-10">
                        <div class="swiper-wrapper">
                            @foreach ($offerProducts as $product)
                                <div class="swiper-slide !h-auto">
                                    <div
                                        class="group relative h-full bg-white border border-gray-200 hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">

                                        <!-- Image Section -->
                                        <a href="{{ route('product.show', $product->slug) }}">
                                            <div class="w-full aspect-square bg-white overflow-hidden relative">
                                                <img src="{{ $product->featured_image_url }}"
                                                    class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 group-hover:opacity-0"
                                                    alt="{{ $product->name }}" loading="lazy"
                                                    onerror="this.src='{{ asset('images/products/default.png') }}'">
                                                <img src="{{ $product->featured_image_url }}"
                                                    class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                                    alt="{{ $product->name }} - Alternate View" loading="lazy"
                                                    onerror="this.src='{{ asset('images/offers/default-bg.jpg') }}'">
                                            </div>
                                        </a>

                                        <!-- Stock Badge -->
                                        @if (!$product->in_stock)
                                            <div
                                                class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 z-20 font-poppins">
                                                OUT OF STOCK
                                            </div>
                                        @elseif($product->is_new)
                                            <div
                                                class="absolute top-2 right-2 bg-accent text-white text-xs font-bold px-2 py-1 z-20 font-poppins">
                                                {{ __('products.new') }}
                                            </div>
                                        @endif

                                        <!-- Buy Now Overlay (in stock) -->
                                        @if ($product->in_stock)
                                            <div
                                                class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                                                <div
                                                    class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                                                    <div class="flex space-x-2">
                                                        <form action="{{ route('checkout.buy-now', $product->id) }}"
                                                            method="POST" class="flex-1 buy-now-form">
                                                            @csrf
                                                            <input type="hidden" name="quantity" value="1"
                                                                class="buy-now-quantity-input">
                                                            <button type="submit"
                                                                class="w-full bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins">
                                                                <span class="flex items-center justify-center">
                                                                    <svg class="w-4 h-4 mr-2 hidden 2xl:block"
                                                                        fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                                    </svg>
                                                                    {{ __('products.buy-now') }}
                                                                </span>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('cart.add', $product->id) }}"
                                                            method="POST" class="add-to-cart-form inline-block">
                                                            @csrf
                                                            <button type="submit"
                                                                class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg">
                                                                <span class="flex items-center">
                                                                    <svg class="w-4 h-4 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                    </svg>
                                                                    Cart
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Contact Overlay (out of stock) -->
                                        @if (!$product->in_stock)
                                            <div
                                                class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                                                <div
                                                    class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('contact') }}"
                                                            class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins">
                                                            <span class="flex items-center justify-center">
                                                                <svg class="w-4 h-4 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                                </svg>
                                                                Contact Us
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Product Info -->
                                        <div class="p-4 border-t border-gray-100 flex-grow flex flex-col">
                                            <a href="{{ route('product.show', $product->slug) }}"
                                                class="font-medium font-poppins text-gray-900 text-sm mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 flex-grow">
                                                {{ $product->name }}
                                            </a>

                                            <!-- Price + Wishlist -->
                                            <div class="mt-auto">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-lg font-bold font-poppins text-gray-900">
                                                        <span
                                                            class="font-bengali">৳</span>{{ number_format($product->price, 0) }}
                                                    </span>

                                                    <div
                                                        class="{{ !$product->in_stock ? 'flex items-center space-x-1' : '' }}">
                                                        <button
                                                            class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                                                            title="Add to Wishlist"
                                                            onclick="event.preventDefault(); addToWishlist({{ $product->id }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 text-gray-400 hover:text-red-500"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                            </svg>
                                                        </button>

                                                        @if ($product->in_stock)
                                                            <form action="{{ route('cart.add', $product->id) }}"
                                                                method="POST" class="add-to-cart-form inline-block">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="add-to-cart-btn p-1 hover:text-primary transition-colors duration-200">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-5 w-5 text-gray-400 hover:text-primary"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('contact') }}" class="p-1"
                                                                target="_blank" title="Call for Availability">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-5 w-5 text-gray-400 hover:text-green-600"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                                </svg>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($product->discount_percentage > 0)
                                                    <div class="flex items-center space-x-2 mt-2 font-inter">
                                                        <span
                                                            class="text-xs bg-accent/10 text-accent font-semibold px-2 py-1">
                                                            Save {{ $product->discount_percentage }}%
                                                        </span>
                                                        <span class="text-xs text-gray-500 line-through">
                                                            <span
                                                                class="font-bengali">৳</span>{{ number_format($product->compare_price, 0) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ✅ Nav buttons scoped by ID, OUTSIDE the swiper div but INSIDE the relative wrapper --}}
                    @if ($offerProducts->count() > 1)
                        <div class="hidden md:flex absolute inset-y-0 left-0 items-center z-[60] pointer-events-none">
                            <button type="button" id="offer-prev-{{ $offer->id }}" aria-label="Previous slide"
                                class="pointer-events-auto w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group">
                                <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        </div>

                        <div class="hidden md:flex absolute inset-y-0 right-0 items-center z-[60] pointer-events-none">
                            <button type="button" id="offer-next-{{ $offer->id }}" aria-label="Next slide"
                                class="pointer-events-auto w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group">
                                <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    @endif

                </div>{{-- end relative wrapper --}}
            </div>
        @endif
    </section>

    {{-- ================== STYLES ================== --}}
    <style>
        @keyframes bg-float {
            0% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.03);
            }

            100% {
                transform: translateY(0) scale(1);
            }
        }

        .animate-bg-float {
            animation: bg-float 16s ease-in-out infinite;
        }
    </style>

    {{-- ================== SCRIPTS ================== --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                // ✅ Timer — scoped to this offer's ID
                const timer = document.getElementById('offer-timer-{{ $offer->id }}');
                if (timer) {
                    const end = new Date(timer.dataset.end).getTime();
                    const tick = () => {
                        const diff = end - Date.now();
                        if (diff <= 0) {
                            clearInterval(interval);
                            return;
                        }
                        timer.querySelector('.days').textContent = String(Math.floor(diff / 86400000)).padStart(2,
                            '0');
                        timer.querySelector('.hours').textContent = String(Math.floor(diff / 3600000) % 24)
                            .padStart(2, '0');
                        timer.querySelector('.minutes').textContent = String(Math.floor(diff / 60000) % 60)
                            .padStart(2, '0');
                        timer.querySelector('.seconds').textContent = String(Math.floor(diff / 1000) % 60).padStart(
                            2, '0');
                    };
                    tick(); // Run immediately so there's no 1-second blank
                    const interval = setInterval(tick, 1000);
                }

                // ✅ Swiper — fully scoped to this offer's ID
                const offerId = {{ $offer->id }};
                const productCount = {{ $offerProducts->count() }};
                const swiperEl = document.querySelector(`.offer-products-swiper-${offerId}`);

                if (swiperEl) {
                    const config = {
                        slidesPerView: 1.3,
                        spaceBetween: 16,
                        // ✅ loop needs at least (slidesPerView * 2) slides to work properly
                        loop: productCount > 5,
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
                        // ✅ Use unique IDs — NOT generic class selectors
                        config.navigation = {
                            nextEl: `#offer-next-${offerId}`,
                            prevEl: `#offer-prev-${offerId}`,
                        };
                    }

                    try {
                        new Swiper(swiperEl, config);
                    } catch (e) {
                        console.error(`Swiper init failed for offer ${offerId}:`, e);
                    }
                }
            });
        </script>
    @endpush
@endif
