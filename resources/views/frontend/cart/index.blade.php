@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')
@section('description', 'Review your shopping cart items')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-poppins">Shopping Cart</h1>
            <p class="text-gray-600 font-inter">Review your items and proceed to checkout</p>
        </div>

        @if ($cart && $cart->items->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8 cart-container">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <!-- Desktop Cart Table -->
                    <div class="hidden md:block bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <!-- Table Header -->
                        <div class="grid grid-cols-12 gap-4 p-6 border-b border-gray-200 bg-gray-50">
                            <div class="col-span-6">
                                <span class="font-semibold text-gray-900 font-inter">Product</span>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="font-semibold text-gray-900 font-inter">Price</span>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="font-semibold text-gray-900 font-inter">Quantity</span>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="font-semibold text-gray-900 font-inter">Total</span>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div class="divide-y divide-gray-200">
                            @foreach ($cart->items as $item)
                                @php
                                    $product = $item->product;
                                    $itemTotal = $item->quantity * $item->price;
                                    $primaryImage = $product->featured_image_url ?? 'images/placeholder.jpg';
                                    $inStock = $product->in_stock;
                                    $maxQuantity = $product->track_quantity ? $product->quantity : 999;
                                @endphp

                                <div class="cart-item grid grid-cols-12 gap-4 p-6 items-center"
                                    data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $item->price }}" data-product-stock="{{ $product->quantity }}"
                                    data-product-in-stock="{{ $product->in_stock ? 'true' : 'false' }}">
                                    <!-- Product Info -->
                                    <div class="col-span-6">
                                        <div class="flex items-center space-x-4">
                                            <!-- Product Image -->
                                            <a href="{{ route('product.show', $product->slug) }}" class="flex-shrink-0">
                                                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                                                    <img src="{{ asset($primaryImage) }}" alt="{{ $product->name }}"
                                                        class="w-full h-full object-contain">
                                                </div>
                                            </a>

                                            <!-- Product Details -->
                                            <div>
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="font-medium text-gray-900 hover:text-primary transition-colors duration-200 font-cambay line-clamp-2">
                                                    {{ $product->name }}
                                                </a>

                                                @if (!$inStock)
                                                    <div class="mt-1">
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800 font-inter">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Out of Stock
                                                        </span>
                                                    </div>
                                                @endif

                                                <!-- Stock info -->
                                                @if ($product->track_quantity)
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        @if ($product->quantity > 0)
                                                            {{ $product->quantity }} in stock
                                                        @else
                                                            Out of stock
                                                        @endif
                                                    </p>
                                                @endif

                                                <!-- Remove Button -->
                                                <button
                                                    class="cart-remove-item mt-2 text-sm text-red-600 hover:text-red-800 font-inter transition-colors duration-200"
                                                    data-url="{{ route('cart.remove', $product->id) }}">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-span-2 text-center">
                                        <span class="text-gray-900 font-semibold font-poppins">
                                            <span class="font-bengali">৳</span>{{ number_format($item->price, 2) }}
                                        </span>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-span-2">
                                        <div class="flex items-center justify-center">
                                            <form action="{{ route('cart.update', $product->id) }}" method="POST"
                                                class="cart-item-form">
                                                @csrf
                                                <div class="flex items-center border border-gray-300 rounded-lg">
                                                    <button type="button"
                                                        class="quantity-decrement px-3 py-2 text-gray-600 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4" />
                                                        </svg>
                                                    </button>

                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                        data-previous-value="{{ $item->quantity }}" min="1"
                                                        max="{{ $maxQuantity }}"
                                                        class="quantity-input w-16 text-center border-0 focus:ring-0 focus:outline-none font-inter [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                        data-product-id="{{ $product->id }}" readonly>

                                                    <button type="button"
                                                        class="quantity-increment px-3 py-2 text-gray-600 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                        {{ !$inStock || ($product->track_quantity && $item->quantity >= $maxQuantity) ? 'disabled' : '' }}>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Total -->
                                    <div class="col-span-2 text-center">
                                        <span class="item-total text-lg font-bold text-gray-900 font-poppins">
                                            <span class="font-bengali">৳</span>{{ number_format($itemTotal, 2) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mobile Cart Items -->
                    <div class="md:hidden space-y-4">
                        @foreach ($cart->items as $item)
                            @php
                                $product = $item->product;
                                $itemTotal = $item->quantity * $item->price;
                                $primaryImage = $product->featured_image_url ?? 'images/placeholder.jpg';
                                $inStock = $product->in_stock;
                                $maxQuantity = $product->track_quantity ? $product->quantity : 999;
                            @endphp

                            <div class="cart-item bg-white rounded-xl border border-gray-200 p-4"
                                data-product-id="{{ $product->id }}">
                                <div class="flex items-start space-x-4">
                                    <!-- Product Image -->
                                    <a href="{{ route('product.show', $product->slug) }}" class="flex-shrink-0">
                                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                                            <img src="{{ asset($primaryImage) }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain">
                                        </div>
                                    </a>

                                    <!-- Product Info -->
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="font-medium text-gray-900 hover:text-primary transition-colors duration-200 font-cambay line-clamp-2">
                                                    {{ $product->name }}
                                                </a>

                                                <div class="mt-1">
                                                    <span class="text-gray-900 font-semibold font-poppins">
                                                        <span
                                                            class="font-bengali">৳</span>{{ number_format($item->price, 2) }}
                                                    </span>
                                                </div>

                                                @if ($product->track_quantity)
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        @if ($product->quantity > 0)
                                                            {{ $product->quantity }} in stock
                                                        @else
                                                            Out of stock
                                                        @endif
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Remove Button -->
                                            <button class="cart-remove-item text-red-600 hover:text-red-800"
                                                data-url="{{ route('cart.remove', $product->id) }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>

                                        @if (!$inStock)
                                            <div class="mt-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800 font-inter">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Out of Stock
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Quantity Controls -->
                                        <div class="mt-4 flex items-center justify-between">
                                            <form action="{{ route('cart.update', $product->id) }}" method="POST"
                                                class="cart-item-form">
                                                @csrf
                                                <div class="flex items-center border border-gray-300 rounded-lg">
                                                    <button type="button"
                                                        class="quantity-decrement px-3 py-2 text-gray-600 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4" />
                                                        </svg>
                                                    </button>

                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                        min="1" max="{{ $maxQuantity }}"
                                                        data-previous-value="{{ $item->quantity }}"
                                                        class="quantity-input w-16 text-center border-0 focus:ring-0 focus:outline-none font-inter [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                        data-product-id="{{ $product->id }}">

                                                    <button type="button"
                                                        class="quantity-increment px-3 py-2 text-gray-600 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                        {{ !$inStock || ($product->track_quantity && $item->quantity >= $maxQuantity) ? 'disabled' : '' }}>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- Item Total -->
                                            <div class="text-right">
                                                <div class="text-sm text-gray-500 font-inter">Total</div>
                                                <div class="item-total text-lg font-bold text-gray-900 font-poppins">
                                                    <span class="font-bengali">৳</span>{{ number_format($itemTotal, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cart Actions -->
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <a href="{{ route('products.index') }}"
                            class="flex items-center text-primary hover:text-primary-dark font-medium font-inter transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Continue Shopping
                        </a>

                        <div class="flex gap-3">
                            <button id="clear-cart-btn" data-url="{{ route('cart.clear') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg font-medium font-inter transition-colors duration-200">
                                Clear Cart
                            </button>
                            @if ($cart->total_items > 0)
                                <a href="{{ route('checkout.index') }}"
                                    class="checkout-btn px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors duration-200 font-poppins">
                                    Proceed to Checkout
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-poppins">Order Summary</h2>

                        <!-- Summary Details -->
                        <div class="space-y-4">
                            <!-- Items Count -->
                            <div class="flex justify-between items-center">
                                <span class="cart-count-text text-gray-600 font-inter">
                                    Items (<span class="cart-count-number">{{ $cart->total_items }}</span>)
                                </span>
                                <span id="cart-subtotal" class="text-gray-900 font-semibold font-poppins"><span
                                        class="font-bengali">৳</span>{{ number_format($cart->subtotal, 2) }}</span>
                            </div>

                            <!-- Shipping -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-inter">Shipping</span>
                                <span class="text-gray-900 font-semibold font-poppins"><span
                                        class="font-bengali">৳</span>0.00</span>
                            </div>

                            <!-- Tax -->
                            {{-- <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-inter">Tax</span>
                                <span class="text-gray-900 font-semibold font-poppins">TK0.00</span>
                            </div> --}}

                            <!-- Divider -->
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900 font-poppins">Total</span>
                                    <div class="text-right">
                                        <div id="cart-total" class="text-2xl font-bold text-gray-900 font-poppins">
                                            <span class="font-bengali">৳</span>{{ number_format($cart->subtotal, 2) }}
                                        </div>
                                        <div class="text-sm text-gray-500 font-inter mt-1">
                                            Including VAT
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        @if ($cart->total_items > 0)
                            <a href="{{ route('checkout.index') }}"
                                class="checkout-btn mt-6 w-full bg-primary hover:bg-primary-dark text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 text-center block font-poppins">
                                Proceed to Checkout
                            </a>
                        @endif
                        <!-- Security Badge -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-inter">Secure checkout</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 font-poppins">Have a Promo Code?</h3>
                        <form class="space-y-3">
                            <div class="flex gap-2">
                                <input type="text" placeholder="Enter promo code"
                                    class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter">
                                <button type="submit"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-medium font-inter transition-colors duration-200">
                                    Apply
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 font-inter">Apply promo code at checkout</p>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="mb-6">
                    <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-700 mb-3 font-poppins">Your cart is empty</h2>
                <p class="text-gray-500 mb-6 font-inter">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors duration-200 font-poppins">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
@endsection
