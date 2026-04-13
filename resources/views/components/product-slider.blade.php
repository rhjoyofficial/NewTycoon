{{-- resources/views/components/product-slider.blade.php --}}
@php
    $totalProducts = count($slidingProducts);
    $totalSlides = $totalProducts;
@endphp

@if ($banner)
    <x-ads-banner :banner="$banner" />
@endif

<section class="max-w-8xl mx-auto py-6 px-4" data-slider-section="{{ $sliderId }}">
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl md:text-2xl lg:text-3xl font-medium text-gray-900 leading-tight font-poppins">
                {{ $title }}</h2>
        </div>
        @if ($showNavigation && $totalSlides >= $slidesPerView)
            <div class="flex items-center space-x-2 hidden md:flex">
                <button
                    class="slider-prev-{{ $sliderId }} w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="slider-next-{{ $sliderId }} w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        @endif
    </div>

    @if ($cardStyle === 'minimal' && $totalProducts > 0)
        <div class="swiper swiper-{{ $sliderId }} relative">
            <div class="swiper-wrapper">
                @foreach ($slidingProducts as $product)
                    {{-- Product slide --}}
                    <div class="swiper-slide !h-auto">
                        @include('components.product-cards.minimal', ['product' => $product])
                    </div>
                @endforeach
            </div>

            @if ($showPagination)
                <div class="swiper-pagination mt-6"></div>
            @endif
        </div>
    @else
        <div class="text-center py-12 border border-gray-200">
            <p class="text-gray-500">No products available.</p>
        </div>
    @endif
</section>

@php
    // $spaceBetween is not passed as a prop; use a sensible default.
    $spaceBetween = $spaceBetween ?? 16;

    if ($totalSlides > 2) {
        $sliderConfig = [
            'loop' => $totalSlides > 1,
            'grabCursor' => true,
            'spaceBetween' => $spaceBetween,
            'slidesPerView' => 1,
            'speed' => 600,
            'effect' => 'slide',
            'breakpoints' => [
                320  => ['slidesPerView' => min(1, $totalSlides), 'spaceBetween' => 8],
                480  => ['slidesPerView' => min(2, $totalSlides), 'spaceBetween' => 10],
                768  => ['slidesPerView' => min(3, $totalSlides), 'spaceBetween' => 12],
                1024 => ['slidesPerView' => min(max(1, $slidesPerView - 1), $totalSlides), 'spaceBetween' => $spaceBetween],
                1280 => ['slidesPerView' => min($slidesPerView, $totalSlides), 'spaceBetween' => $spaceBetween],
            ],
        ];

        if ($autoPlay && $totalSlides > 1) {
            $sliderConfig['autoplay'] = [
                'delay' => 4000,
                'disableOnInteraction' => false,
                'pauseOnMouseEnter' => true,
            ];
        }

        if ($showNavigation && $totalSlides > 1) {
            $sliderConfig['navigation'] = [
                'nextEl' => '.slider-next-' . $sliderId,
                'prevEl' => '.slider-prev-' . $sliderId,
            ];
        }

        if ($showPagination && $totalSlides > 1) {
            $sliderConfig['pagination'] = [
                'el' => '.swiper-pagination',
                'clickable' => true,
                'dynamicBullets' => true,
            ];
        }
    }
@endphp

@if ($totalSlides > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderElement = document.querySelector('.swiper-{{ $sliderId }}');
            if (sliderElement) {
                const sliderConfig = @json($sliderConfig ?? []);
                if (Object.keys(sliderConfig).length > 0) {
                    try {
                        new Swiper(sliderElement, sliderConfig);
                    } catch (error) {
                        console.error('Product slider initialization error:', error);
                    }
                }
            }
        });
    </script>
@endif
