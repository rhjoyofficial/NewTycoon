<!-- Products Section -->
<section class="py-6 md:py-12 bg-gray-50 featured-products-section">
    <div class="max-w-8xl mx-auto px-4">
        <!-- Section Title -->
        <div class="flex justify-between items-end mb-6 md:mb-10">
            <h2
                class="category-heading text-xl md:text-2xl lg:text-3xl font-medium text-gray-900 leading-tight capitalize font-poppins">
                {{ __('common.featured-products') }}
            </h2>

            <a href="{{ route('products.featured') }}"
                class="group inline-flex items-center gap-1 transform text-gray-900 text-sm 2xl:text-base font-inter font-normal tracking-wide transition-colors duration-300 hover:text-primary">

                <span class="hover:underline">View All</span>

                <svg class="w-4 h-4 xl:w-5 xl:h-5 transition-colors duration-300 group-hover:text-primary"
                    fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M26.68 3.867H8.175a1 1 0 0 0 0 2h16.544L4.2 26.387A1 1 0 1 0 5.613 27.8l20.52-20.52v16.545a1 1 0 0 0 2 0V5.321a1.456 1.456 0 0 0-1.453-1.454"
                        data-name="Layer 2" />
                </svg>
            </a>
        </div>
        <!-- Skeletons -->
        <div class="featured-skeletons grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-6">
            @for ($i = 0; $i < 8; $i++)
                <div class="skeleton-card"></div>
            @endfor
        </div>

        <!-- Products Grid -->
        <div
            class="featured-products grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-6 hidden">
            @foreach ($products as $product)
                <div class="group bg-white rounded-md lg:rounded-3xl overflow-hidden relative featured-product-card">
                    <!-- Product Image with Overlay -->
                    <a href="{{ route('product.show', $product->slug) }}" class="block relative">
                        <div class="relative w-full aspect-square bg-gray-100 overflow-hidden">
                            <img src="{{ $product->featured_image_url }}"
                                class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105">

                            <!-- Product Badges -->
                            @if ($product->is_new)
                                <span
                                    class="absolute top-3 left-3 bg-gradient-to-r from-primary to-primary-dark text-white text-[10px] md:text-xs font-bold  px-1 py-0.5 md:px-3 md:py-1 rounded-full font-inter">
                                    {{ __('products.new') }}
                                </span>
                            @endif

                            {{-- @if ($product->discount_percentage > 0)
                                <div class="absolute top-2 right-2 w-16 md:w-20 drop-shadow-lg">

                                    <svg viewBox="0 0 600 200" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">

                                        <defs>
                                            <linearGradient id="gradRed" x1="0%" y1="0%" x2="0%"
                                                y2="100%">
                                                <stop offset="0%" stop-color="#ff3a3a" />
                                                <stop offset="100%" stop-color="#ff1f1f" />
                                            </linearGradient>

                                            <linearGradient id="gradWhite" x1="0%" y1="0%" x2="0%"
                                                y2="100%">
                                                <stop offset="0%" stop-color="#dedbd2" />
                                                <stop offset="100%" stop-color="#cfcac1" />
                                            </linearGradient>

                                            <mask id="ticketMask">
                                                <rect width="600" height="200" rx="20" fill="#fff" />
                                                <!-- Side ticket holes -->
                                                <circle cy="40" r="18" />
                                                <circle cy="80" r="18" />
                                                <circle cy="120" r="18" />
                                                <circle cy="160" r="18" />
                                                <circle cx="600" cy="40" r="18" />
                                                <circle cx="600" cy="80" r="18" />
                                                <circle cx="600" cy="120" r="18" />
                                                <circle cx="600" cy="160" r="18" />
                                            </mask>
                                        </defs>

                                        <!-- Background halves -->
                                        <path fill="url(#gradRed)" mask="url(#ticketMask)" d="M0 0h300v200H0z" />
                                        <path fill="url(#gradWhite)" mask="url(#ticketMask)" d="M300 0h300v200H300z" />

                                        <!-- Discount Number -->
                                        <text x="40" y="145" font-size="130" font-weight="bold" fill="#fff"
                                            font-family="Arial, sans-serif">
                                            {{ format_number($product->discount_percentage) }}
                                        </text>

                                        <!-- Percent -->
                                        <text x="190" y="115" font-size="85" font-weight="bold" fill="#fff"
                                            font-family="Arial, sans-serif">
                                            %
                                        </text>

                                        <!-- OFF -->
                                        <text x="320" y="145" font-size="130" font-weight="bold" fill="#333"
                                            letter-spacing="3" font-family="Arial, sans-serif">
                                            {{ __('products.off') }}
                                        </text>

                                    </svg>
                                </div>
                            @endif --}}

                            <!-- Hover Overlay with Actions -->
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div
                                    class="transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 space-y-3">
                                    @if ($product->in_stock)
                                        <form action="{{ route('checkout.buy-now', $product->id) }}" method="POST"
                                            class="flex-1 buy-now-form">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1"
                                                class="buy-now-quantity-input">
                                            <button type="submit"
                                                class="w-full bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins rounded-full">
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
                                    @else
                                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                            class="add-to-wishlist-form inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="wishlist-btn bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center space-x-2"
                                                title="Add to Wishlist">
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                                <span class="font-poppins">Add to Wishlist</span>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Quick Actions -->
                                    <div class="flex justify-center space-x-3">
                                        <button title="View Details"
                                            class="bg-white p-3 rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-110"
                                            onclick="quickView({{ $product->id }})">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                            class="add-to-cart-form inline-block">
                                            @csrf
                                            <button type="submit" title="Add to Cart"
                                                class="add-to-cart-btn bg-white p-3 rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-110 {{ !$product->in_stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ !$product->in_stock ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Product Info - Elegant with Divider -->
                    <div class="p-2 md:p-5">
                        <!-- Product Name -->
                        <a href="{{ route('product.show', $product->slug) }}" class="block mb-1"
                            title="{{ $product->name }}">
                            <h3
                                class="text-sm font-medium text-gray-900 hover:text-primary transition-colors duration-200 line-clamp-2 mb-1 font-poppins">
                                {{ $product->name }}
                            </h3>
                        </a>

                        <!-- Divider -->
                        <div class="h-px bg-gray-200 mb-1"></div>

                        <!-- Price Section -->
                        <div class="space-y-1">
                            @if ($product->discount_percentage > 0)
                                <div class="flex items-end justify-between">
                                    <div>
                                        <span class="text-base md:text-xl font-bold  text-gray-900 font-poppins">
                                            <span class="font-bengali">৳</span>
                                            {{ format_currency($product->price, '') }}
                                        </span>
                                        <div class="md:mt-1">
                                            <span class="text-sm md:text-base text-gray-500 line-through font-poppins">
                                                <span class="font-bengali">৳</span>
                                                {{ format_currency($product->compare_price, '') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-between pt-1">
                                            <div class="flex items-center md:space-x-1">
                                                <!-- Wishlist Icon -->
                                                <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                                    class="add-to-wishlist-form inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="wishlist-btn p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                                        title="Add to Wishlist">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 hover:text-red-500"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <!-- Cart/Call Icon -->
                                                @if ($product->in_stock)
                                                    <form action="{{ route('cart.add', $product->id) }}"
                                                        method="POST" class="add-to-cart-form inline-block">
                                                        @csrf
                                                        <button type="submit"
                                                            class="add-to-cart-btn p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                                            title="Add to Cart"
                                                            {{ !$product->in_stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                            {{ !$product->in_stock ? 'disabled' : '' }}>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 hover:text-primary"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('contact') }}"
                                                        class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 inline-block"
                                                        title="Call for Availability +8801714XXXXXX">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 hover:text-green-600"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21.97 18.33C21.97 18.69 21.89 19.06 21.72 19.42C21.55 19.78 21.33 20.12 21.04 20.44C20.55 20.98 20.01 21.37 19.4 21.62C18.8 21.87 18.15 22 17.45 22C16.43 22 15.34 21.76 14.19 21.27C13.04 20.78 11.89 20.12 10.75 19.29C9.6 18.45 8.51 17.52 7.47 16.49C6.44 15.45 5.51 14.36 4.68 13.22C3.86 12.08 3.2 10.94 2.72 9.81C2.24 8.67 2 7.58 2 6.54C2 5.86 2.12 5.21 2.36 4.61C2.6 4 2.98 3.44 3.51 2.94C4.15 2.31 4.85 2 5.59 2C5.87 2 6.15 2.06 6.4 2.18C6.66 2.3 6.89 2.48 7.07 2.74L9.39 6.01C9.57 6.26 9.7 6.49 9.79 6.71C9.88 6.92 9.93 7.13 9.93 7.32C9.93 7.56 9.86 7.8 9.72 8.03C9.59 8.26 9.4 8.5 9.16 8.74L8.4 9.53C8.29 9.64 8.24 9.77 8.24 9.93C8.24 10.01 8.25 10.08 8.27 10.16C8.3 10.24 8.33 10.3 8.35 10.36C8.53 10.69 8.84 11.12 9.28 11.64C9.73 12.16 10.21 12.69 10.73 13.22C11.27 13.75 11.79 14.24 12.32 14.69C12.84 15.13 13.27 15.43 13.61 15.61C13.66 15.63 13.72 15.66 13.79 15.69C13.87 15.72 13.95 15.73 14.04 15.73C14.21 15.73 14.34 15.67 14.45 15.56L15.21 14.81C15.46 14.56 15.7 14.37 15.93 14.25C16.16 14.11 16.39 14.04 16.64 14.04C16.83 14.04 17.03 14.08 17.25 14.17C17.47 14.26 17.7 14.39 17.95 14.56L21.26 16.91C21.52 17.09 21.7 17.3 21.81 17.55C21.91 17.8 21.97 18.05 21.97 18.33Z" />
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <span class="hidden md:inline-block text-xs text-emerald-600 font-medium">
                                            {{ $product->in_stock ? '✓ Available' : '✗ Sold Out' }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start justify-between">
                                    <span class="text-2xl font-bold text-gray-900 font-poppins">
                                        <span class="font-bengali">৳</span>{{ format_currency($product->price, '') }}
                                    </span>
                                    <div>
                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-1">
                                                <!-- Wishlist Icon -->
                                                <form action="{{ route('wishlist.add', $product->id) }}"
                                                    method="POST" class="add-to-wishlist-form inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="wishlist-btn p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                                        title="Add to Wishlist">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 hover:text-red-500"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <!-- Cart Icon -->
                                                <button type="button"
                                                    class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                                    title="Add to Cart">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 hover:text-primary"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <span class="hidden md:inline-block text-xs text-primary font-medium">
                                            {{ $product->in_stock ? '✓ Available' : '✗ Sold Out' }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
