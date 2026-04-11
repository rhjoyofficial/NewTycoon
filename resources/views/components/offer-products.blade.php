{{-- ==================OFFER SECTION CONTENT ================== --}}
<section class="relative z-10 max-w-8xl mx-auto px-4 py-14">

    {{-- ================== MAIN BANNER ================== --}}
    <div class="relative overflow-hidden mb-10 aspect-[28/5]">

        {{-- Banner Image --}}
        @if ($offer->main_banner_image)
            <img src="{{ asset($offer->main_banner_image) }}"
                class="absolute inset-0 w-full h-full object-cover aspect-[28/5]" alt="{{ $offer->title }}" />
            <div class="absolute inset-0 bg-black/40"></div>
        @endif

        {{-- Banner Content --}}
        <div class="relative z-10 p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">

            {{-- Title --}}
            <div class="text-center md:text-left">
                <h2 class="text-white text-3xl md:text-4xl font-bold font-poppins mb-2">
                    {{ $offer->title }}
                </h2>
                <p class="text-white/90 text-base md:text-lg font-cambay max-w-xl">
                    {{ $offer->subtitle }}
                </p>
            </div>

            {{-- Timer --}}
            @if ($offer->timer_enabled && $offer->timer_end_date)
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-6 py-4">
                    <div class="text-xs text-white/80 text-center mb-1">OFFER ENDS IN</div>

                    <div id="offer-timer" data-end="{{ $offer->timer_end_date }}"
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
                <h3 class="text-xl md:text-2xl lg:text-4xl font-medium text-gray-900 leading-tight font-poppins">
                    {{ $offer->short_description }}
                </h3>


                <a href="{{ $offer->formatted_view_all_link }}" target="_self"
                    class="group inline-flex items-center gap-1 transform text-gray-900 text-sm 2xl:text-base font-inter font-normal tracking-wide transition-colors duration-300 hover:text-primary">

                    <span class="hover:underline">{{ $offer->view_all_text ?? 'View More Products' }}</span>

                    <svg class="w-4 h-4 xl:w-5 xl:h-5 transition-colors duration-300 group-hover:text-primary"
                        fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M26.68 3.867H8.175a1 1 0 0 0 0 2h16.544L4.2 26.387A1 1 0 1 0 5.613 27.8l20.52-20.52v16.545a1 1 0 0 0 2 0V5.321a1.456 1.456 0 0 0-1.453-1.454"
                            data-name="Layer 2" />
                    </svg>
                </a>
            </div>

            {{-- Swiper --}}
            <div class="swiper offer-products-swiper pb-10">
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
                                            class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-300 group-hover:opacity-100 {{ !$product->featured_image_url ? 'group-hover:scale-105' : '' }}"
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

                                <!-- Buy Now Overlay -->
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
                                                            <svg class="w-4 h-4 mr-2 hidden 2xl:block" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                            </svg>
                                                            {{ __('products.buy-now') }}
                                                        </span>
                                                    </button>
                                                </form>

                                                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                    class="add-to-cart-form inline-block">
                                                    @csrf
                                                    <button type="submit" title="Add to Cart"
                                                        class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
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

                                @if (!$product->in_stock)
                                    <div
                                        class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                                        <div
                                            class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('contact') }}" title="+8801714XXXXXX"
                                                    class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins">
                                                    <span class="flex items-center justify-center">
                                                        <!-- Contact/Phone Icon -->
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

                                            <!-- Quick Actions -->
                                            <div
                                                class="{{ !$product->in_stock ? 'flex items-center space-x-1' : '' }} ">
                                                <button
                                                    class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                                                    title="Add to Wishlist"
                                                    onclick="event.preventDefault(); addToWishlist({{ $product->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-gray-400 hover:text-red-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg>
                                                </button>

                                                @if ($product->in_stock)
                                                    <form action="{{ route('cart.add', $product->id) }}"
                                                        method="POST" class="add-to-cart-form inline-block">
                                                        @csrf
                                                        <button type="submit" title="Add to Cart"
                                                            class="add-to-cart-btn p-1 hover:text-primary transition-colors duration-200 {{ !$product->in_stock ? 'opacity-50 cursor-not-allowed' : '' }} "
                                                            title="Add to Cart"
                                                            {{ !$product->in_stock ? 'disabled' : '' }}>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 text-gray-400 hover:text-primary"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('contact') }}" class="p-1" target="_blank"
                                                        title="Call for Availability +8801714XXXXXX">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-gray-400 hover:text-green-600"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21.97 18.33C21.97 18.69 21.89 19.06 21.72 19.42C21.55 19.78 21.33 20.12 21.04 20.44C20.55 20.98 20.01 21.37 19.4 21.62C18.8 21.87 18.15 22 17.45 22C16.43 22 15.34 21.76 14.19 21.27C13.04 20.78 11.89 20.12 10.75 19.29C9.6 18.45 8.51 17.52 7.47 16.49C6.44 15.45 5.51 14.36 4.68 13.22C3.86 12.08 3.2 10.94 2.72 9.81C2.24 8.67 2 7.58 2 6.54C2 5.86 2.12 5.21 2.36 4.61C2.6 4 2.98 3.44 3.51 2.94C4.15 2.31 4.85 2 5.59 2C5.87 2 6.15 2.06 6.4 2.18C6.66 2.3 6.89 2.48 7.07 2.74L9.39 6.01C9.57 6.26 9.7 6.49 9.79 6.71C9.88 6.92 9.93 7.13 9.93 7.32C9.93 7.56 9.86 7.8 9.72 8.03C9.59 8.26 9.4 8.5 9.16 8.74L8.4 9.53C8.29 9.64 8.24 9.77 8.24 9.93C8.24 10.01 8.25 10.08 8.27 10.16C8.3 10.24 8.33 10.3 8.35 10.36C8.53 10.69 8.84 11.12 9.28 11.64C9.73 12.16 10.21 12.69 10.73 13.22C11.27 13.75 11.79 14.24 12.32 14.69C12.84 15.13 13.27 15.43 13.61 15.61C13.66 15.63 13.72 15.66 13.79 15.69C13.87 15.72 13.95 15.73 14.04 15.73C14.21 15.73 14.34 15.67 14.45 15.56L15.21 14.81C15.46 14.56 15.7 14.37 15.93 14.25C16.16 14.11 16.39 14.04 16.64 14.04C16.83 14.04 17.03 14.08 17.25 14.17C17.47 14.26 17.7 14.39 17.95 14.56L21.26 16.91C21.52 17.09 21.7 17.3 21.81 17.55C21.91 17.8 21.97 18.05 21.97 18.33Z" />
                                                        </svg>
                                                    </a>
                                                @endif

                                            </div>
                                        </div>

                                        @if ($product->discount_percentage > 0)
                                            <div class="flex items-center space-x-2 mt-2 font-inter">
                                                <span class="text-xs bg-accent/10 text-accent font-semibold px-2 py-1">
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

                {{-- Swiper Navigation --}}
                @if (count($offerProducts) > 1)
                    <!-- Swiper Navigation -->
                    <div class="hidden md:flex absolute inset-y-0 left-0 items-center z-[60] pointer-events-none">
                        <button type="button" aria-label="Previous slide"
                            class="swiper-button-prev pointer-events-auto w-6 h-6 xl:w-8 xl:h-8 2xl:w-12 2xl:h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-primary/30 transition-all duration-300 flex items-center justify-center group active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed">

                            <svg class="w-3 h-3 2xl:w-5 2xl:h-5 text-gray-700 group-hover:text-primary transition-colors"
                                viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                            </svg>
                        </button>
                    </div>

                    <div class="hidden md:flex absolute inset-y-0 right-0 items-center z-[60] pointer-events-none">
                        <button type="button" aria-label="Next slide"
                            class="swiper-button-next pointer-events-auto w-6 h-6 xl:w-8 xl:h-8 2xl:w-12 2xl:h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-primary/30 transition-all duration-300 flex items-center justify-center group active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed">

                            <svg class="w-3 h-3 2xl:w-5 2xl:h-5 text-gray-700 group-hover:text-primary transition-colors"
                                viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M8.59 16.59 10 18l6-6-6-6-1.41 1.41L13.17 12z" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
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

            // TIMER
            const timer = document.getElementById('offer-timer');
            if (timer) {
                const end = new Date(timer.dataset.end).getTime();

                setInterval(() => {
                    const now = Date.now();
                    const diff = end - now;

                    if (diff <= 0) return;

                    timer.querySelector('.days').textContent = Math.floor(diff / 86400000);
                    timer.querySelector('.hours').textContent = Math.floor(diff / 3600000) % 24;
                    timer.querySelector('.minutes').textContent = Math.floor(diff / 60000) % 60;
                    timer.querySelector('.seconds').textContent = Math.floor(diff / 1000) % 60;
                }, 1000);
            }

            // SWIPER
            const offerSwiperElement = document.querySelector('.offer-products-swiper');
            if (offerSwiperElement) {
                const productCount = {{ count($offerProducts) }};
                // console.log('Initializing Swiper with product count:', productCount);
                const swiperConfig = {
                    slidesPerView: 1.3,
                    spaceBetween: 16,
                    loop: true,
                    grabCursor: true,
                    speed: 500,
                    breakpoints: {
                        480: {
                            slidesPerView: Math.min(2.2, productCount),
                            spaceBetween: 16,
                        },
                        640: {
                            slidesPerView: Math.min(2.5, productCount),
                            spaceBetween: 18,
                        },
                        768: {
                            slidesPerView: Math.min(3, productCount),
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: Math.min(4, productCount),
                            spaceBetween: 24,
                        },
                        1280: {
                            slidesPerView: Math.min(5, productCount),
                            spaceBetween: 24,
                        },
                    },

                };

                // Add navigation if more than 1 product
                if (productCount > 1) {
                    swiperConfig.navigation = {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    };
                    swiperConfig.pagination = {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    };
                }

                try {
                    new Swiper(offerSwiperElement, swiperConfig);
                } catch (error) {
                    console.error('Swiper initialization error:', error);
                }
            }
        });
    </script>
@endpush
