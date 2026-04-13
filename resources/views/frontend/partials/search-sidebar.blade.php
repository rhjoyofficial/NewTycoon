<!-- resources/views/frontend/partials/search-sidebar.blade.php -->
<div class="lg:w-1/4">
    <div class="bg-white rounded-xl p-6 mb-6 border border-gray-200 sticky top-6">
        <!-- Search Filter -->
        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3 font-poppins">
                @isset($currentCategory)
                    Search in {{ $currentCategory->name }}
                @else
                    Search
                @endisset
            </h3>
            <form method="GET" action="{{ $route ?? route('search') }}" id="searchForm">
                <div class="relative">
                    <input type="text" name="{{ $searchParam ?? 'q' }}" value="{{ $search ?? '' }}"
                        placeholder="Search products..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter">
                    <button type="submit" class="absolute right-3 top-2.5">
                        <svg class="w-5 h-5 text-gray-400 hover:text-primary" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Category Filter -->
        @if (($isCategoryPage ?? false) && isset($parentCategory))
            <!-- For Category Page: Show subcategories of current category -->
            @php
                // Get all child categories including nested ones
                $allChildCategories = $allChildCategories ?? collect();

                // Group by parent_id for hierarchical display
                $groupedCategories = $allChildCategories->groupBy('parent_id');

                // Get direct children (parent_id = current category id)
                $directChildren = $groupedCategories->get($parentCategory->children, collect());
            @endphp

            @if ($directChildren->count() > 0)
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Subcategories</h3>
                    <div class="space-y-2 max-h-96 overflow-y-auto border-b border-gray-200 shadow-sm pb-2">
                        <!-- "All [Category Name]" option -->
                        <a href="{{ route('categories.show', array_merge([$parentCategory->slug], request()->except(['category', 'search']))) }}"
                            class="flex items-center justify-between px-3 py-2 rounded-lg {{ !request('category') ? 'bg-primary-light text-primary border border-primary' : 'hover:bg-gray-50 border border-gray-200' }} font-inter transition-colors">
                            <span class="font-medium">All {{ $parentCategory->name }}</span>
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                {{ $allProductsCount }}
                            </span>
                        </a>

                        @foreach ($directChildren as $category)
                            @php
                                $categoryProductCount = $category->products_count;
                            @endphp

                            @if ($categoryProductCount > 0)
                                <div class="category-item">
                                    <a href="{{ route('categories.show', array_merge([$parentCategory->slug], request()->except('category'), ['category' => $category->id])) }}"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg {{ request('category') == $category->id ? 'bg-primary-light text-primary border border-primary' : 'hover:bg-gray-50 border border-gray-200' }} font-inter transition-colors">
                                        <div class="flex items-center flex-1">
                                            <span class="truncate">{{ $category->name }}</span>
                                        </div>
                                        <span class="text-xs bg-gray-100 px-2 py-1 rounded min-w-[2rem] text-center">
                                            {{ $categoryProductCount }}
                                        </span>
                                    </a>

                                    <!-- Show grandchildren if any -->
                                    @if ($groupedCategories->has($category->id))
                                        <div class="ml-4 mt-1 space-y-1">
                                            @foreach ($groupedCategories->get($category->id) as $child)
                                                @php
                                                    $childProductCount = $child->products_count ?? 0;
                                                @endphp

                                                @if ($childProductCount > 0)
                                                    <a href="{{ route('categories.show', array_merge([$parentCategory->slug], request()->except('category'), ['category' => $child->id])) }}"
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
        @else
            <!-- For Search Page: Show all categories -->
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
                                        <span class="text-xs bg-gray-100 px-2 py-1 rounded min-w-[2rem] text-center">
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
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary price-slider"
                        data-target="min">
                    <input type="range" name="max_price" min="{{ $priceRange['min'] }}"
                        max="{{ $priceRange['max'] }}" value="{{ request('max_price', $priceRange['max']) }}"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer mt-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary price-slider"
                        data-target="max">
                </div>
                <div class="flex gap-2">
                    <input type="number" name="min_price_input" value="{{ request('min_price', $priceRange['min']) }}"
                        min="{{ $priceRange['min'] }}" max="{{ $priceRange['max'] }}"
                        class="w-1/2 px-3 py-2 border border-gray-300 rounded text-sm font-inter price-input"
                        placeholder="Min" data-target="min">
                    <input type="number" name="max_price_input" value="{{ request('max_price', $priceRange['max']) }}"
                        min="{{ $priceRange['min'] }}" max="{{ $priceRange['max'] }}"
                        class="w-1/2 px-3 py-2 border border-gray-300 rounded text-sm font-inter price-input"
                        placeholder="Max" data-target="max">
                </div>
            </div>
        </div>

        <!-- Status Filter -->
        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3 font-poppins">Status</h3>
            <div class="grid grid-cols-2 gap-2">
                @if (isset($currentCategory))
                    <a href="{{ route('categories.show', array_merge([$currentCategory->slug], request()->except('status'), ['status' => 'all'])) }}"
                        class="px-3 py-2 text-center rounded-lg border {{ request('status', 'all') == 'all' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                        All
                    </a>
                    <a href="{{ route('categories.show', array_merge([$currentCategory->slug], request()->except('status'), ['status' => 'in_stock'])) }}"
                        class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'in_stock' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                        In Stock
                    </a>
                    <a href="{{ route('categories.show', array_merge([$currentCategory->slug], request()->except('status'), ['status' => 'new'])) }}"
                        class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'new' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                        New
                    </a>
                    <a href="{{ route('categories.show', array_merge([$currentCategory->slug], request()->except('status'), ['status' => 'discounted'])) }}"
                        class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'discounted' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                        On Sale
                    </a>
                    <a href="{{ route('categories.show', array_merge([$currentCategory->slug], request()->except('status'), ['status' => 'featured'])) }}"
                        class="px-3 py-2 text-center rounded-lg border {{ request('status') == 'featured' ? 'bg-primary-light text-primary border-primary' : 'border-gray-200 hover:bg-gray-50' }} text-sm font-inter transition-colors">
                        Featured
                    </a>
                @else
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
                @endif
            </div>
        </div>

        <!-- Clear Filters Button -->
        @if (request()->hasAny(['category', 'min_price', 'max_price', 'status', 'sort', 'search']))
            @if (isset($currentCategory))
                <a href="{{ route('categories.show', $currentCategory->slug) }}"
                    class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-medium text-center font-inter transition-colors duration-200">
                    Clear All Filters
                </a>
            @else
                <a href="{{ route('search', ['q' => $search ?? '']) }}"
                    class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-medium text-center font-inter transition-colors duration-200">
                    Clear All Filters
                </a>
            @endif
        @endif
    </div>
</div>
