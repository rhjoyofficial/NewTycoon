{{-- resources/views/components/offer-product-card.blade.php --}}
@props(['product', 'offer'])

@php
    $primaryImage = $product['images'][0] ?? asset('images/products/placeholder.jpg');
    $secondaryImage = $product['images'][1] ?? $primaryImage;
@endphp

<div
    class="group relative h-full bg-white border border-gray-200 hover:shadow-lg transition-all duration-300 flex flex-col rounded-xl overflow-hidden">
    <!-- Image Section -->
    <a href="{{ $product['url'] }}">
        <div class="w-full aspect-square bg-white overflow-hidden relative">
            <img src="{{ $primaryImage }}"
                class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 group-hover:opacity-0"
                alt="{{ $product['name'] }}" loading="lazy"
                onerror="this.src='{{ asset('images/products/default.png') }}'">
            <img src="{{ $secondaryImage }}"
                class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-300 group-hover:opacity-100 {{ $secondaryImage === $primaryImage ? 'group-hover:scale-105' : '' }}"
                alt="{{ $product['name'] }} - Alternate View" loading="lazy" onerror="this.src='{{ $primaryImage }}'">
        </div>
    </a>

    <!-- Stock Badge -->
    @if (!$product['in_stock'])
        <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 z-20 font-poppins">
            OUT OF STOCK
        </div>
    @elseif($product['is_new'])
        <div class="absolute top-2 right-2 bg-accent text-white text-xs font-bold px-2 py-1 z-20 font-poppins">
            {{ __('products.new') }}
        </div>
    @endif

    <!-- Buy Now Overlay -->
    @if ($product['in_stock'])
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

                    <form action="{{ $product['add_to_cart_url'] }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg">
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

    @if (!$product['in_stock'])
        <div
            class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
            <div class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                <div class="flex space-x-2">
                    <a href="{{ route('contact') }}"
                        class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins">
                        <span class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <a href="{{ $product['url'] }}"
            class="font-medium font-poppins text-gray-900 text-sm mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 flex-grow">
            {{ $product['name'] }}
        </a>

        <!-- Price + Wishlist -->
        <div class="mt-auto">
            <div class="flex items-center justify-between">
                <span class="text-lg font-bold font-poppins text-gray-900">
                    <span class="font-bengali">৳</span>{{ number_format($product['discounted_price'], 0) }}
                </span>

                @if (!$product['in_stock'])
                    <button class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                        data-product-id="{{ $product['id'] }}" title="Add to Wishlist">
                        <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                @endif
            </div>

            @if ($product['discount_percentage'] > 0)
                <div class="flex items-center space-x-2 mt-2 font-inter">
                    <span class="text-xs bg-accent/10 text-accent font-semibold px-2 py-1">
                        Save {{ $product['discount_percentage'] }}%
                    </span>
                    <span class="text-xs text-gray-500 line-through">
                        <span class="font-bengali">৳</span>{{ number_format($product['original_price'], 0) }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Wishlist functionality
        document.querySelectorAll('.wishlist-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const productId = this.dataset.productId;

                // Add wishlist AJAX call here
                fetch('/api/wishlist/add', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                }).then(response => {
                    if (response.ok) {
                        this.classList.add('text-red-500');
                        this.querySelector('svg').classList.add('fill-red-500');
                        showToast('Added to wishlist!', 'success');
                    }
                }).catch(error => {
                    console.error('Error adding to wishlist:', error);
                    showToast('Failed to add to wishlist', 'error');
                });
            });
        });

        function showToast(message, type = 'info') {
            // Implement toast notification
            const toast = document.createElement('div');
            toast.className =
                `fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg z-50 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
@endpush
