@extends('frontend.layouts.app')

@section('title', $title ?? 'All Products')
@section('description', $description ?? 'Browse our collection of products')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-poppins">{{ $title ?? 'All Products' }}</h1>
            <p class="text-gray-600 font-inter"> {{ $description ?? 'Browse our complete collection of premium products' }}
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div
                    class="bg-white rounded-xl p-6 mb-6 border border-gray-200 lg:sticky lg:top-6 max-h-[calc(100vh-2rem)] overflow-y-auto no-scrollbar">
                    <!-- Search Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Search</h3>
                        <form method="GET" action="{{ route('products.index') }}" id="searchForm">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search products..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                    aria-label="Search products">
                                <button type="submit" class="absolute right-3 top-2.5" aria-label="Submit search">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                            <!-- Hidden fields to preserve other filters -->
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if (request('min_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            @endif
                            @if (request('max_price'))
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            @endif
                            @if (request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                        </form>
                    </div>

                    <!-- Category Filter -->
                    @if ($categories->count() > 0)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Categories</h3>
                            <div class="space-y-2 max-h-96 overflow-y-auto no-scrollbar border-b border-gray-200 shadow-sm"
                                role="navigation" aria-label="Category filters">
                                <!-- FIXED: Simplified 'All Categories' link -->
                                <a href="{{ route('products.index', request()->except('category')) }}"
                                    class="block px-3 py-2 rounded-lg {{ !request('category') ? 'bg-primary-light text-primary border border-primary' : 'hover:bg-gray-50 border border-gray-200' }} font-inter transition-colors">
                                    All Categories
                                </a>
                                @foreach ($categories as $cat)
                                    <!-- FIXED: Only preserve search and sort when changing category -->
                                    <a href="{{ route('products.index', array_merge(request()->only(['search', 'sort']), ['category' => $cat->id])) }}"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg {{ request('category') == $cat->id ? 'bg-primary-light text-primary border border-primary' : 'hover:bg-gray-50 border border-gray-200' }} font-inter transition-colors">
                                        <span>{{ $cat->name }}</span>
                                        <span
                                            class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $cat->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Price Range</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700 font-inter"><span
                                        class="font-bengali">৳</span>{{ number_format(request('min_price', $priceRange['min'])) }}</span>
                                <span class="text-sm font-medium text-gray-700 font-inter"><span
                                        class="font-bengali">৳</span>{{ number_format(request('max_price', $priceRange['max'])) }}</span>
                            </div>
                            <div class="px-2">
                                <input type="range" id="min_price_slider" min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}" value="{{ request('min_price', $priceRange['min']) }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary"
                                    aria-label="Minimum price">
                                <input type="range" id="max_price_slider" min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}" value="{{ request('max_price', $priceRange['max']) }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer mt-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary"
                                    aria-label="Maximum price">
                            </div>
                            <div class="flex gap-2">
                                <input type="number" id="min_price_input"
                                    value="{{ request('min_price', $priceRange['min']) }}" min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded text-sm font-inter"
                                    placeholder="Min" aria-label="Minimum price input">
                                <input type="number" id="max_price_input"
                                    value="{{ request('max_price', $priceRange['max']) }}" min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded text-sm font-inter"
                                    placeholder="Max" aria-label="Maximum price input">
                            </div>
                            <button type="button" id="apply_price_filter"
                                class="w-full px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg font-medium text-center font-inter transition-colors duration-200">
                                Apply Price Filter
                            </button>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Status</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- FIXED: Removed 'status' param instead of setting to 'all' -->
                            <a href="{{ route('products.index', request()->except('status')) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ !request('status') ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                All
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except('status'), ['status' => 'in_stock'])) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'in_stock' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                In Stock
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except('status'), ['status' => 'new'])) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'new' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                New
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except('status'), ['status' => 'discounted'])) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'discounted' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                On Sale
                            </a>
                        </div>
                    </div>

                    <!-- Clear Filters Button -->
                    @if (request()->hasAny(['search', 'category', 'min_price', 'max_price', 'status', 'sort']))
                        <a href="{{ route('products.index') }}"
                            class="block w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-medium text-center font-inter transition-colors duration-200">
                            Clear All Filters
                        </a>
                    @endif
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <!-- Sort Options -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 bg-white p-4 rounded-xl border border-gray-200">
                    <p class="text-gray-600 font-inter">
                        Showing <span class="font-semibold">{{ $products->firstItem() ?? 0 }}</span>
                        to <span class="font-semibold">{{ $products->lastItem() ?? 0 }}</span>
                        of <span class="font-semibold">{{ $products->total() }}</span> products
                    </p>

                    <div class="flex items-center gap-2">
                        <label for="sortSelect" class="text-gray-700 font-inter text-sm">Sort by:</label>
                        <select name="sort" id="sortSelect"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-inter focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest
                            </option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to
                                High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High
                                to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z
                            </option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A
                            </option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular
                            </option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                @if ($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($products as $product)
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

                            <!-- Product Card -->
                            <div
                                class="group relative h-full bg-white border border-gray-200 hover:border-primary rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col">
                                <!-- Image Section -->
                                <a href="{{ route('product.show', $productSlug) }}"
                                    aria-label="View {{ $productName }}">
                                    <div
                                        class="relative w-full aspect-square bg-gradient-to-br from-gray-50 to-white overflow-hidden">
                                        <!-- Primary Image -->
                                        <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $productName }}"
                                            loading="lazy"
                                            class="absolute inset-0 w-full h-full object-contain transition-opacity duration-500 group-hover:opacity-0 p-4">

                                        <!-- Secondary Image on Hover -->
                                        <img src="{{ asset('storage/' . $secondaryImage) }}" alt="{{ $productName }}"
                                            loading="lazy"
                                            class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-500 group-hover:opacity-100 p-4">

                                        <!-- Badges -->
                                        <div class="absolute top-3 left-3 flex flex-col space-y-1 z-10">
                                            @if ($isNew)
                                                <span
                                                    class="bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold px-3 py-1.5 font-poppins rounded">
                                                    NEW
                                                </span>
                                            @endif
                                            @if (!$inStock)
                                                <span
                                                    class="bg-gray-700/90 text-white text-xs font-bold px-3 py-1.5 font-poppins rounded">
                                                    SOLD OUT
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Discount Badge -->
                                        @if ($discountPercentage > 0)
                                            <div class="absolute top-3 right-3 z-10">
                                                <span
                                                    class="bg-gradient-to-r from-accent to-orange-500 text-white text-xs font-bold px-3 py-1.5 font-poppins rounded">
                                                    -{{ $discountPercentage }}% OFF
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <!-- Product Info -->
                                <div class="p-4 border-t border-gray-100 flex-grow flex flex-col">

                                    <a href="{{ route('product.show', $productSlug) }}" title="{{ $productName }}"
                                        class="font-medium font-poppins text-gray-900 text-sm mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                                        {{ $productName }}
                                    </a>
                                    <!-- Price + Wishlist -->
                                    <div class="mt-auto">
                                        <div class="flex items-center justify-between">
                                            <!-- FIXED: No decimal for BDT -->
                                            <span class="text-lg font-bold font-poppins text-gray-900">
                                                <span class="font-bengali">৳</span>{{ number_format($finalPrice, 0) }}
                                            </span>

                                            <!-- FIXED: Wishlist with proper form and CSRF -->
                                            @if ($inStock)
                                                @auth
                                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                                        class="wishlist-form inline-block">
                                                        @csrf
                                                        <button type="submit"
                                                            class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                                                            aria-label="Add {{ $productName }} to wishlist">
                                                            <svg class="w-5 h-5 text-gray-400 hover:text-red-500"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('login') }}"
                                                        class="p-1 hover:text-red-500 transition-colors duration-200"
                                                        aria-label="Login to add to wishlist">
                                                        <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    </a>
                                                @endauth
                                            @endif
                                        </div>

                                        <!-- FIXED: Show actual savings amount -->
                                        @if ($discountPercentage > 0 && $savingsAmount > 0)
                                            <div class="flex items-center space-x-2 mt-2 font-inter">
                                                <span
                                                    class="text-xs bg-accent/10 text-accent font-semibold px-2 py-1 rounded">
                                                    Save <span
                                                        class="font-bengali">৳</span>{{ number_format($savingsAmount, 0) }}
                                                </span>
                                                <span class="text-xs text-gray-500 line-through">
                                                    <span
                                                        class="font-bengali">৳</span>{{ number_format($originalPrice, 0) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Quick Actions Overlay -->
                                @if ($inStock)
                                    <div
                                        class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20 opacity-0 group-hover:opacity-100">
                                        <div
                                            class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('checkout.process', $productId) }}"
                                                    class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins rounded-lg">
                                                    <span class="flex items-center justify-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                        </svg>
                                                        Buy
                                                    </span>
                                                </a>

                                                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                    class="add-to-cart-form inline-block">
                                                    @csrf
                                                    <button type="submit" title="Add to Cart"
                                                        class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg rounded-lg">
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
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 mt-6">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Products Found -->
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                        <div class="mb-6">
                            <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2 font-poppins">No products found</h3>
                        <p class="text-gray-500 mb-6 font-inter">Try adjusting your filters or search terms</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors duration-200 font-poppins">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FIXED: Sort select change handler
            const sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    updateUrlParameter('sort', this.value);
                });
            }

            // Price range elements
            const minPriceSlider = document.getElementById('min_price_slider');
            const maxPriceSlider = document.getElementById('max_price_slider');
            const minPriceInput = document.getElementById('min_price_input');
            const maxPriceInput = document.getElementById('max_price_input');
            const applyPriceFilterBtn = document.getElementById('apply_price_filter');

            // Sync sliders with inputs
            if (minPriceSlider && minPriceInput) {
                minPriceSlider.addEventListener('input', function() {
                    minPriceInput.value = this.value;
                });
                minPriceInput.addEventListener('input', function() {
                    minPriceSlider.value = this.value;
                });
            }

            if (maxPriceSlider && maxPriceInput) {
                maxPriceSlider.addEventListener('input', function() {
                    maxPriceInput.value = this.value;
                });
                maxPriceInput.addEventListener('input', function() {
                    maxPriceSlider.value = this.value;
                });
            }

            // Apply price filter button
            if (applyPriceFilterBtn) {
                applyPriceFilterBtn.addEventListener('click', function() {
                    const minPrice = minPriceInput.value;
                    const maxPrice = maxPriceInput.value;

                    // Validate price range
                    if (parseInt(minPrice) > parseInt(maxPrice)) {
                        alert('Minimum price cannot be greater than maximum price');
                        return;
                    }

                    // Update both parameters at once
                    const url = new URL(window.location.href);
                    url.searchParams.set('min_price', minPrice);
                    url.searchParams.set('max_price', maxPrice);
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                });
            }

            // FIXED: Removed auto-submit search debounce - only submit on form submit
            const searchForm = document.getElementById('searchForm');
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    // Let the form submit naturally
                });
            }

            // Helper function to update URL parameters
            function updateUrlParameter(key, value) {
                const url = new URL(window.location.href);

                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }

                // Remove page parameter when changing filters
                url.searchParams.delete('page');

                window.location.href = url.toString();
            }
        });
    </script>
@endpush
