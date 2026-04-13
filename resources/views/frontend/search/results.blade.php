@extends('frontend.layouts.app')

@section('title', $search ? "Search Results for: \"$search\"" : 'Search Products')
@section('description', 'Find what you\'re looking for in our collection')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-8">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-poppins">
                @if ($search)
                    Search Results for: "<span class="text-primary">{{ $search }}</span>"
                @else
                    Search Products
                @endif
            </h1>
            <div class="flex items-center text-gray-600 font-inter">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p>Found <span class="font-semibold">{{ $products->total() }}</span> results</p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-xl p-6 mb-6 border border-gray-200 sticky top-6">
                    <!-- Search Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Search</h3>
                        <form method="GET" action="{{ route('search') }}" id="searchForm">
                            <div class="relative">
                                <input type="text" name="q" value="{{ $search }}"
                                    placeholder="Search products..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter">
                                <button type="submit" class="absolute right-3 top-2.5">
                                    <svg class="w-5 h-5 text-gray-400 hover:text-primary" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Category Filter -->
                    @if ($categories->count() > 0)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Categories</h3>
                            <div class="space-y-2 max-h-96 overflow-y-auto border-b border-gray-200 shadow-sm pb-2">
                                <a href="{{ route('search', array_merge(request()->except('category'), ['category' => null])) }}"
                                    class="flex items-center justify-between px-3 py-2 rounded-lg {{ !request('category') ? 'bg-primary-light text-primary border border-primary' : 'hover:bg-gray-50 border border-gray-200' }} font-inter transition-colors">
                                    <span class="font-medium">All Categories</span>
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                        {{ $allProductsCount }}
                                    </span>
                                </a>

                                @foreach ($categories as $category)
                                    @php
                                        $categoryProductCount = $category->products_count;
                                    @endphp


                                    @if ($categoryProductCount > 0)
                                        <div class="category-item">
                                            <a href="{{ route('search', array_merge(request()->except('category'), ['category' => $category->id])) }}"
                                                class="flex items-center justify-between px-3 py-2 rounded-lg {{ request('category') == $category->id ? 'bg-primary-light text-primary border border-primary' : 'hover:bg-gray-50 border border-gray-200' }} font-inter transition-colors">
                                                <div class="flex items-center flex-1">
                                                    <span class="truncate">{{ $category->name }}</span>
                                                </div>
                                                <span
                                                    class="text-xs bg-gray-100 px-2 py-1 rounded min-w-[2rem] text-center">
                                                    {{ $categoryProductCount }}
                                                </span>
                                            </a>

                                            @if ($category->children->count() > 0)
                                                <div class="ml-4 mt-1 space-y-1">
                                                    @foreach ($category->children as $child)
                                                        @php
                                                            $childProductCount = $child->products_count ?? 0;
                                                        @endphp

                                                        @if ($childProductCount > 0)
                                                            <a href="{{ route('search', array_merge(request()->except('category'), ['category' => $child->id])) }}"
                                                                class="flex items-center justify-between px-3 py-2 rounded-lg {{ request('category') == $child->id ? 'bg-primary-light text-primary border border-primary' : 'hover:bg-gray-50 border border-gray-200' }} font-inter transition-colors">
                                                                <span class="truncate">{{ $child->name }}</span>
                                                                <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                                                    {{ $childProductCount }}
                                                                </span>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Price Range</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700 font-inter">
                                    <span
                                        class="font-bengali">৳</span>{{ number_format(request('min_price', $priceRange['min'])) }}
                                </span>
                                <span class="text-sm font-medium text-gray-700 font-inter">
                                    <span
                                        class="font-bengali">৳</span>{{ number_format(request('max_price', $priceRange['max'])) }}
                                </span>
                            </div>
                            <div class="px-2">
                                <input type="range" name="min_price" min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}" value="{{ request('min_price', $priceRange['min']) }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary">
                                <input type="range" name="max_price" min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}" value="{{ request('max_price', $priceRange['max']) }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer mt-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary">
                            </div>
                            <div class="flex gap-2">
                                <input type="number" name="min_price_input"
                                    value="{{ request('min_price', $priceRange['min']) }}" min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded text-sm font-inter"
                                    placeholder="Min">
                                <input type="number" name="max_price_input"
                                    value="{{ request('max_price', $priceRange['max']) }}" min="{{ $priceRange['min'] }}"
                                    max="{{ $priceRange['max'] }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded text-sm font-inter"
                                    placeholder="Max">
                            </div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Status</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('search', array_merge(request()->except('status'), ['status' => 'all'])) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ request('status', 'all') == 'all' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                All
                            </a>
                            <a href="{{ route('search', array_merge(request()->except('status'), ['status' => 'in_stock'])) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'in_stock' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                In Stock
                            </a>
                            <a href="{{ route('search', array_merge(request()->except('status'), ['status' => 'new'])) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'new' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                New
                            </a>
                            <a href="{{ route('search', array_merge(request()->except('status'), ['status' => 'discounted'])) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'discounted' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                On Sale
                            </a>
                            <a href="{{ route('search', array_merge(request()->except('status'), ['status' => 'featured'])) }}"
                                class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'featured' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                                Featured
                            </a>
                        </div>
                    </div>

                    <!-- Clear Filters Button -->
                    @if (request()->hasAny(['category', 'min_price', 'max_price', 'status', 'sort']))
                        <a href="{{ route('search', ['q' => $search]) }}"
                            class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-medium text-center font-inter transition-colors duration-200">
                            Clear All Filters
                        </a>
                    @endif
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <!-- Results Summary -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 bg-white p-4 rounded-xl border border-gray-200">
                    <p class="text-gray-600 font-inter">
                        Showing <span class="font-semibold">{{ $products->firstItem() ?? 0 }}</span>
                        to <span class="font-semibold">{{ $products->lastItem() ?? 0 }}</span>
                        of <span class="font-semibold">{{ $products->total() }}</span> results
                    </p>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-700 font-inter text-sm">Sort by:</span>
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
                            <!-- Product Card -->
                            <div
                                class="group relative h-full bg-white border border-gray-200 hover:border-primary rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col">
                                <!-- Image Section -->
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <div
                                        class="relative w-full aspect-square bg-gradient-to-br from-gray-50 to-white overflow-hidden">
                                        <!-- Primary Image -->
                                        <img src="{{ $product->featured_images[0] }}" alt="{{ $product->name }}"
                                            class="absolute inset-0 w-full h-full object-contain transition-opacity duration-500 group-hover:opacity-0">

                                        <!-- Secondary Image on Hover (if available) -->
                                        @if ($product->gallery_images && count($product->gallery_images) > 0)
                                            <img src="{{ $product->gallery_images[0] }}" alt="{{ $product->name }}"
                                                class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-500 group-hover:opacity-100">
                                        @else
                                            <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}"
                                                class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-500 group-hover:opacity-100">
                                        @endif

                                        <!-- Badges -->
                                        <div class="absolute top-3 left-3 flex flex-col space-y-1 z-10 items-start">
                                            @if ($product->is_new)
                                                <span
                                                    class="inline-block bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold px-2 py-1 font-poppins rounded">
                                                    NEW
                                                </span>
                                            @endif
                                            @if ($product->stock_status !== 'in_stock')
                                                <span
                                                    class="inline-block bg-gray-700/90 text-white text-xs font-bold px-2 py-1 font-poppins rounded">
                                                    {{ strtoupper(str_replace('_', ' ', $product->stock_status)) }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Discount Badge -->
                                        @if ($product->discount_percentage > 0)
                                            <div class="absolute top-3 right-3 z-10">
                                                <span
                                                    class="bg-gradient-to-r from-accent to-orange-500 text-white text-xs font-bold px-3 py-1.5 font-poppins rounded">
                                                    -{{ $product->discount_percentage }}% OFF
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <!-- Product Info -->
                                <div class="p-4 border-t border-gray-100 flex-grow flex flex-col">
                                    <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}"
                                        class="font-medium font-poppins text-gray-900 text-sm mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 flex-grow">
                                        {{ $product->name }}
                                    </a>

                                    <!-- Price + Wishlist -->
                                    <div class="mt-auto">
                                        <div class="flex items-center justify-between">
                                            <span class="text-lg font-bold font-poppins text-gray-900">
                                                <span class="font-bengali">৳</span>{{ number_format($product->price, 2) }}
                                            </span>

                                            <button
                                                class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                                                title="Add to Wishlist">
                                                <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        @if ($product->discount_percentage > 0)
                                            <div class="flex items-center space-x-2 mt-2 font-inter">
                                                <span class="text-xs bg-accent/10 text-accent font-semibold px-2 py-1">
                                                    Save {{ $product->discount_percentage }}%
                                                </span>
                                                <span class="text-xs text-gray-500 line-through">
                                                    <span
                                                        class="font-bengali">৳</span>{{ number_format($product->compare_price, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Quick Actions Overlay -->
                                @if ($product->stock_status === 'in_stock')
                                    <div
                                        class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20 opacity-0 group-hover:opacity-100">
                                        <div
                                            class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('checkout.process', $product->id) }}"
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
                                                        class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white
                                                        font-semibold py-2.5 px-4 transition-colors duration-200 text-sm
                                                        shadow-lg rounded-lg">
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
                                @else
                                    <div
                                        class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20 opacity-0 group-hover:opacity-100">
                                        <div
                                            class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('contact') }}" title="+8801714XXXXXX"
                                                    class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-poppins rounded-lg">
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
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="mt-8">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Results Found -->
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                        <div class="mb-6">
                            <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2 font-poppins">No results found</h3>
                        <p class="text-gray-500 mb-6 font-inter">
                            @if ($search)
                                No products found for "<span class="font-semibold">{{ $search }}</span>"
                            @else
                                Try searching for something
                            @endif
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('products.index') }}"
                                class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors duration-200 font-poppins">
                                Browse All Products
                            </a>
                            <a href="{{ route('search') }}"
                                class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-lg transition-colors duration-200 font-poppins">
                                Clear Search
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sort select change handler
            const sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('sort', this.value);
                    window.location.href = url.toString();
                });
            }

            // Price range slider handlers
            const minPriceSlider = document.querySelector('input[name="min_price"]');
            const maxPriceSlider = document.querySelector('input[name="max_price"]');
            const minPriceInput = document.querySelector('input[name="min_price_input"]');
            const maxPriceInput = document.querySelector('input[name="max_price_input"]');

            function updatePriceFilters() {
                const url = new URL(window.location.href);

                // Get values from inputs if they exist
                const minValue = minPriceInput ? minPriceInput.value : minPriceSlider.value;
                const maxValue = maxPriceInput ? maxPriceInput.value : maxPriceSlider.value;

                url.searchParams.set('min_price', minValue);
                url.searchParams.set('max_price', maxValue);

                // Remove price params if they're at defaults
                if (minValue === '{{ $priceRange['min'] }}') {
                    url.searchParams.delete('min_price');
                }
                if (maxValue === '{{ $priceRange['max'] }}') {
                    url.searchParams.delete('max_price');
                }

                window.location.href = url.toString();
            }

            // Add debounce function to prevent too many requests
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            const debouncedUpdate = debounce(updatePriceFilters, 800);

            // Attach event listeners
            if (minPriceSlider && maxPriceSlider) {
                minPriceSlider.addEventListener('input', function() {
                    if (minPriceInput) minPriceInput.value = this.value;
                    debouncedUpdate();
                });

                maxPriceSlider.addEventListener('input', function() {
                    if (maxPriceInput) maxPriceInput.value = this.value;
                    debouncedUpdate();
                });
            }

            if (minPriceInput && maxPriceInput) {
                minPriceInput.addEventListener('change', debouncedUpdate);
                maxPriceInput.addEventListener('change', debouncedUpdate);
            }

            // Search form submission with debounce
            const searchInput = document.querySelector('input[name="q"]');
            if (searchInput) {
                searchInput.addEventListener('keyup', debounce(function(e) {
                    if (e.key === 'Enter') {
                        document.getElementById('searchForm').submit();
                    }
                }, 500));
            }
        });
    </script>
@endpush
