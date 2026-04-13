<!-- resources/views/components/product-cards/minimal.blade.php -->
@php
    $productSlug = $product->slug;
    $productId = $product->id;
    $productName = $product->name;

    $featuredImages = is_array($product->featured_images) ? $product->featured_images : [];
    $galleryImages = is_array($product->gallery_images) ? $product->gallery_images : [];

    $primaryImage = !empty($featuredImages)
        ? $featuredImages[0]
        : (!empty($galleryImages)
            ? $galleryImages[0]
            : 'products/placeholder.jpg');

    $secondaryImage = !empty($featuredImages)
        ? $featuredImages[1] ?? $featuredImages[0]
        : (!empty($galleryImages)
            ? $galleryImages[1] ?? $galleryImages[0]
            : $primaryImage);

    $finalPrice = $product->price;
    $originalPrice = $product->compare_price ?: $product->price;
    $discountPercentage = $product->discount_percentage;
    $savingsAmount = $originalPrice - $finalPrice;

    $inStock = $product->in_stock;
    $isNew = $product->is_new ?? false;
    $rating = $product->average_rating ?? 0;
    $reviewCount = $product->rating_count ?? 0;
@endphp
<div
    class="group relative h-full bg-white border border-gray-200 hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">

    <!-- Image Section -->
    <a href="{{ route('product.show', $productSlug) }}">
        <div class="w-full aspect-square bg-white overflow-hidden relative">
            <img src="{{ $product->featured_image_url }}"
                class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 group-hover:opacity-0">
            <img src="{{ asset('storage/' . ($secondaryImage ?? $primaryImage)) }}"
                class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-300 group-hover:opacity-100 {{ !$secondaryImage ? 'group-hover:scale-105' : '' }}">
        </div>

    </a>

    <!-- Stock Badge -->
    @if (!$inStock)
        <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 z-20 font-poppins">
            OUT OF STOCK
        </div>
    @elseif($isNew)
        <div class="absolute top-2 right-2 bg-accent text-white text-xs font-bold px-2 py-1 z-20 font-poppins">
            {{ __('products.new') }}
        </div>
    @endif

    <!-- Buy Now Overlay -->
    @if ($inStock)
        <div
            class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
            <div class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                <div class="flex space-x-2">
                    <form action="{{ route('checkout.buy-now', $product->id) }}" method="POST"
                        class="flex-1 buy-now-form">
                        @csrf
                        <input type="hidden" name="quantity" value="1" class="buy-now-quantity-input">
                        <button type="submit"
                            class="w-full bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins">
                            <span class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2 hidden 2xl:block" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Buy Now
                            </span>
                        </button>
                    </form>

                    <form action="{{ route('cart.add', $productId) }}" method="POST"
                        class="add-to-cart-form inline-block">
                        @csrf
                        <button type="submit" title="Add to Cart"
                            class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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

    @if (!$inStock)
        <div
            class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
            <div class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                <div class="flex space-x-2">
                    <a href="{{ route('contact') }}" title="+8801714XXXXXX"
                        class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins">
                        <span class="flex items-center justify-center">
                            <!-- Contact/Phone Icon -->
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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

        <a href="{{ route('product.show', $productSlug) }}"
            class="font-medium font-poppins text-gray-900 text-sm mb-3 line-clamp-1 group-hover:text-primary transition-colors duration-200 flex-grow">
            {{ $productName }}
        </a>

        <!-- Price + Wishlist -->
        <div class="mt-auto">
            <div class="flex items-center justify-between">
                <span class="text-lg font-bold font-poppins text-gray-900">
                    <span class="font-bengali">৳</span>{{ format_currency($finalPrice, '') }}
                </span>

                <!-- Quick Actions -->
                <div class="{{ !$inStock ? 'flex items-center space-x-1' : '' }} ">
                    <button class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                        title="Add to Wishlist" onclick="event.preventDefault(); addToWishlist({{ $productId }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-red-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>

                    @if ($inStock)
                        <form action="{{ route('cart.add', $productId) }}" method="POST"
                            class="add-to-cart-form inline-block">
                            @csrf
                            <button type="submit" title="Add to Cart"
                                class="add-to-cart-btn p-1 hover:text-primary transition-colors duration-200 {{ !$inStock ? 'opacity-50 cursor-not-allowed' : '' }} "
                                title="Add to Cart" {{ !$inStock ? 'disabled' : '' }}>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-primary"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('contact') }}" class="p-1" target="_blank"
                            title="Call for Availability +8801714XXXXXX">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-green-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21.97 18.33C21.97 18.69 21.89 19.06 21.72 19.42C21.55 19.78 21.33 20.12 21.04 20.44C20.55 20.98 20.01 21.37 19.4 21.62C18.8 21.87 18.15 22 17.45 22C16.43 22 15.34 21.76 14.19 21.27C13.04 20.78 11.89 20.12 10.75 19.29C9.6 18.45 8.51 17.52 7.47 16.49C6.44 15.45 5.51 14.36 4.68 13.22C3.86 12.08 3.2 10.94 2.72 9.81C2.24 8.67 2 7.58 2 6.54C2 5.86 2.12 5.21 2.36 4.61C2.6 4 2.98 3.44 3.51 2.94C4.15 2.31 4.85 2 5.59 2C5.87 2 6.15 2.06 6.4 2.18C6.66 2.3 6.89 2.48 7.07 2.74L9.39 6.01C9.57 6.26 9.7 6.49 9.79 6.71C9.88 6.92 9.93 7.13 9.93 7.32C9.93 7.56 9.86 7.8 9.72 8.03C9.59 8.26 9.4 8.5 9.16 8.74L8.4 9.53C8.29 9.64 8.24 9.77 8.24 9.93C8.24 10.01 8.25 10.08 8.27 10.16C8.3 10.24 8.33 10.3 8.35 10.36C8.53 10.69 8.84 11.12 9.28 11.64C9.73 12.16 10.21 12.69 10.73 13.22C11.27 13.75 11.79 14.24 12.32 14.69C12.84 15.13 13.27 15.43 13.61 15.61C13.66 15.63 13.72 15.66 13.79 15.69C13.87 15.72 13.95 15.73 14.04 15.73C14.21 15.73 14.34 15.67 14.45 15.56L15.21 14.81C15.46 14.56 15.7 14.37 15.93 14.25C16.16 14.11 16.39 14.04 16.64 14.04C16.83 14.04 17.03 14.08 17.25 14.17C17.47 14.26 17.7 14.39 17.95 14.56L21.26 16.91C21.52 17.09 21.7 17.3 21.81 17.55C21.91 17.8 21.97 18.05 21.97 18.33Z" />
                            </svg>
                        </a>
                    @endif

                </div>
            </div>

            @if ($discountPercentage > 0)
                <div class="flex items-center space-x-2 mt-2 font-inter">
                    <span class="text-xs bg-accent/10 text-accent font-semibold px-2 py-1">
                        Save {{ format_number($discountPercentage) }}%
                    </span>
                    <span class="text-xs text-gray-500 line-through">
                        <span class="font-bengali">৳</span>{{ format_currency($originalPrice, '') }}
                    </span>
                </div>
            @endif
        </div>
    </div>

</div>
