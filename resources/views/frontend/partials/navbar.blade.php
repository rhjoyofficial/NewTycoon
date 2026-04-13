<!-- resources/views/components/navbar.blade.php -->
<nav class="bg-[#111827] fixed top-0 left-0 right-0 z-50 font-sans border-b shadow-sm">
    <!-- TOP BAR -->
    <div class="top-bar border-b border-gray-200">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" aria-label="Home">
                        <img src="{{ asset('images/wh-logo.png') }}" alt="BK Logo" class="h-7 md:h-8 w-auto">
                    </a>
                </div>

                <div class="hidden lg:flex justify-center items-center flex-1">
                    <!-- All Categories Mega Menu (desktop) -->
                    <div class="relative group ml-2">
                        <button id="all-categories-btn"
                            class="flex items-center space-x-1 px-4 py-2 bg-accent hover:bg-primary/80 text-base font-medium text-white border border-gray-300 rounded-l-lg">
                            <span id="selected-category-text">{{ __('home.all-categories') }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Mega menu dropdown (three columns) -->
                        <div
                            class="categories-mega-menu absolute left-0 top-full mt-2 w-[720px] bg-white shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="grid grid-cols-3 min-h-[300px]">
                                <!-- Level 1 -->
                                <div class="border-r border-gray-100">
                                    @foreach ($categoriesDropdown as $category)
                                        <div class="group/level1 relative">
                                            <button
                                                class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary flex justify-between items-center category-level1 category-selectable"
                                                data-id="{{ $category['id'] }}" data-name="{{ $category['name'] }}"
                                                data-slug="{{ $category['slug'] }}">
                                                <span class="truncate">{{ $category['name'] }}</span>
                                                @if ($category['has_children'])
                                                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:-rotate-90"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Level 2 -->
                                <div class="level2-container border-r border-gray-100 hidden"></div>

                                <!-- Level 3 -->
                                <div class="level3-container hidden"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Search -->
                    <div class="flex-1 max-w-xl mr-4">
                        <div class="relative" id="desktop-search-container">
                            <form action="{{ route('search') }}" method="GET" class="relative flex">
                                <input type="text" name="q" placeholder="Search for products..."
                                    autocomplete="off"
                                    class="w-full py-2 pl-10 pr-4 text-base bg-gray-100 border border-gray-300 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-300"
                                    id="desktop-search-input">
                                <input type="hidden" name="category" id="desktop-selected-category" value="">
                                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <button type="submit"
                                    class="bg-accent text-base text-white px-3 py-2 border border-gray-300 hover:bg-primary/80 transition-colors  rounded-r-lg">{{ __('home.search') }}</button>
                            </form>

                            <!-- Search suggestions dropdown -->
                            <div id="desktop-search-suggestions"
                                class="absolute left-0 right-0 mt-1 bg-white shadow-lg border border-gray-200 hidden z-50 max-h-96 overflow-y-auto">
                                <div class="p-2">
                                    <!-- Popular searches (shown when input empty) -->
                                    <div id="desktop-popular-searches" class="px-3 py-2">
                                        <p class="text-xs font-medium text-gray-500 mb-2">
                                            {{ __('home.popular-searches') }}</p>
                                        <div id="desktop-popular-loading" class="hidden flex items-center space-x-2">
                                            <div class="animate-spin h-4 w-4 border-b-2 border-primary"></div>
                                            <span class="text-sm text-gray-600">Loading popular searches...</span>
                                        </div>
                                        <div id="desktop-popular-results" class="flex flex-wrap gap-2">
                                            @foreach ($topSearchedTerms as $term)
                                                <a href="{{ route('search') }}?q={{ urlencode($term->term) }}"
                                                    class="px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-sm text-gray-700">
                                                    {{ $term->term }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Loading state -->
                                    <div id="desktop-search-loading" class="hidden px-3 py-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="animate-spin h-4 w-4 border-b-2 border-primary"></div>
                                            <span class="text-sm text-gray-600">Searching...</span>
                                        </div>
                                    </div>

                                    <!-- No results -->
                                    <div id="desktop-search-empty" class="hidden px-3 py-2 text-sm text-gray-500">
                                        No results found. Try different keywords.
                                    </div>

                                    <!-- Suggestions list -->
                                    <div id="desktop-search-results" class="mt-2"></div>

                                    <!-- View all results -->
                                    <div id="desktop-search-view-all" class="hidden border-t border-gray-100 mt-2 pt-2">
                                        <a href="#" id="desktop-search-view-all-link"
                                            class="flex items-center justify-center text-primary hover:text-primary-dark font-medium text-sm py-2 px-3 bg-gray-50 hover:bg-gray-100">
                                            <span>View all results</span>
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Catalog link (desktop) -->
                <a href="{{ route('catalogs') }}"
                    class="hidden lg:block text-white text-base font-medium px-3 py-2 border border-transparent hover:border-gray-300 hover:bg-primary rounded-lg transition duration-200 mr-2">
                    {{ __('home.catalogs') }}
                </a>

                <!-- Right icons (language, user, cart, mobile menu) -->
                <div class="flex items-center space-x-1">
                    <!-- Language -->
                    <div class="hidden lg:block">
                        <a href="{{ url('language/' . (app()->getLocale() == 'en' ? 'bn' : 'en')) }}"
                            class="text-base font-medium text-white px-3 py-2 border border-transparent hover:border-gray-300 bg-accent hover:bg-primary leading-tight rounded-lg transition duration-200 inline-block">
                            {{ app()->getLocale() == 'en' ? 'বাংলা' : 'English' }}
                        </a>
                    </div>

                    <!-- User icon + dropdown -->
                    <div class="relative group">
                        <button class="p-2 text-white hover:text-primary hover:bg-gray-100 rounded-full">
                            <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="0.5"
                                    d="M9.667 3.5a3.532 3.532 0 1 0 0 7.063 3.532 3.532 0 0 0 0-7.063M4.636 7.032a5.032 5.032 0 1 1 10.063 0 5.032 5.032 0 0 1-10.063 0m10.8-2.564a.75.75 0 0 1 .75-.75 4.13 4.13 0 1 1-.83 8.178.75.75 0 0 1 .3-1.47q.256.052.53.053a2.63 2.63 0 1 0 0-5.261.75.75 0 0 1-.75-.75m1.001 9.34a.75.75 0 0 1 .75-.75 4.75 4.75 0 0 1 4.75 4.75v.725a1.75 1.75 0 0 1-1.75 1.75h-.877a.75.75 0 1 1 0-1.5h.877a.25.25 0 0 0 .25-.25v-.725a3.25 3.25 0 0 0-3.25-3.25.75.75 0 0 1-.75-.75M2.062 19a5.75 5.75 0 0 1 5.75-5.75h3.713a5.75 5.75 0 0 1 5.75 5.75v.25a2.75 2.75 0 0 1-2.75 2.75H4.812a2.75 2.75 0 0 1-2.75-2.75zm5.75-4.25A4.25 4.25 0 0 0 3.562 19v.25c0 .69.56 1.25 1.25 1.25h9.713c.69 0 1.25-.56 1.25-1.25V19a4.25 4.25 0 0 0-4.25-4.25z"
                                    fill-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- User dropdown menu -->
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white shadow-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 rounded-lg">
                            <div class="py-1">
                                @auth
                                    @if (auth()->user()->hasAnyRole(['admin', 'moderator']))
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Admin
                                            Dashboard</a>
                                    @endif
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('orders.track') }}"
                                        class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Track Order</a>
                                    @if (auth()->user()->hasRole('customer'))
                                        <a href="/orders"
                                            class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">My Orders</a>
                                    @endif
                                    @if (auth()->user()->hasPermission('manage_products'))
                                        <a href="/admin/products"
                                            class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Products
                                            Management</a>
                                    @endif
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Logout</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Sign In</a>
                                    <a href="{{ route('register') }}"
                                        class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Sign Up</a>
                                    <hr class="my-1">
                                    <a href="{{ route('orders.track') }}"
                                        class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Track Order</a>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Cart icon -->
                    <a href="{{ route('cart.index') }}"
                        class="p-2 text-white hover:text-primary hover:bg-gray-100 relative rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span
                            class="cart-badge absolute -top-1 -right-1 bg-primary text-white text-xs font-bold h-5 w-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount ?? 0 }}</span>
                    </a>

                    <!-- Mobile search icon -->
                    <button id="mobile-search-toggle"
                        class="lg:hidden p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <!-- Mobile menu button -->
                    <button class="lg:hidden p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-full"
                        id="mobile-menu-button">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- CATEGORY BAR (desktop only) -->
    <div class="hidden lg:block bg-gray-50 border-t border-gray-200">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center items-center h-12 space-x-6">
                @foreach ($navigation as $item)
                    @if (isset($item['children']) && count($item['children']) > 0)
                        <div class="relative group">
                            <span class="flex items-baseline space-x-1">
                                <a href="{{ $item['url'] }}"
                                    class="text-gray-800 hover:text-primary text-base font-semibold py-2 inline-block border-b-2 border-transparent hover:border-primary">
                                    {{ $item['name'] }}
                                </a>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180 text-gray-800 hover:text-accent"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>

                            <!-- First level dropdown -->
                            <div
                                class="absolute left-0 top-full mt-2 w-48 bg-white shadow-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    @foreach ($item['children'] as $child)
                                        @if (isset($child['children']) && count($child['children']) > 0)
                                            <div class="relative group/sub">
                                                <a href="{{ $child['url'] }}"
                                                    class="block px-4 py-2 text-sm font-medium text-gray-800 hover:text-accent hover:bg-gray-100 flex justify-between items-center">
                                                    <span>{{ $child['name'] }}</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                                <!-- Second level dropdown -->
                                                <div
                                                    class="absolute left-full top-0 w-48 bg-white shadow-md border border-gray-200 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200">
                                                    <div class="py-2">
                                                        @foreach ($child['children'] as $grandchild)
                                                            <a href="{{ $grandchild['url'] }}"
                                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                {{ $grandchild['name'] }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ $child['url'] }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                {{ $child['name'] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $item['url'] }}"
                            class="text-gray-800 hover:text-primary text-base font-semibold py-2 inline-block border-b-2 border-transparent hover:border-primary">
                            {{ $item['name'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- MOBILE MENU (collapsible) -->
    <div class="lg:hidden hidden bg-white border-t border-gray-200" id="mobile-menu">
        <div class="px-4 py-3 space-y-1 max-h-[80vh] overflow-y-auto">
            @foreach ($categoriesDropdown as $item)
                @if (isset($item['children']) && count($item['children']) > 0)
                    <div class="relative">
                        <button
                            class="mobile-dropdown-toggle w-full text-left text-gray-700 hover:text-primary block px-3 py-2 text-base font-semibold flex items-center justify-between">
                            <span>{{ $item['name'] }}</span>
                            <svg class="w-4 h-4 mobile-dropdown-arrow transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="mobile-dropdown hidden pl-4 border-l border-gray-200 ml-2">
                            @foreach ($item['children'] as $child)
                                @if (isset($child['children']) && count($child['children']) > 0)
                                    <div class="relative">
                                        <button
                                            class="mobile-subdropdown-toggle w-full text-left text-gray-600 hover:text-primary block px-3 py-2 text-sm font-semibold flex items-center justify-between">
                                            <span>{{ $child['name'] }}</span>
                                            <svg class="w-3 h-3 mobile-subdropdown-arrow transition-transform duration-200"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="mobile-subdropdown hidden pl-4 border-l border-gray-200 ml-2">
                                            @foreach ($child['children'] as $grandchild)
                                                <a href="{{ $grandchild['url'] }}"
                                                    class="block px-3 py-2 text-gray-500 hover:text-primary text-xs">
                                                    {{ $grandchild['name'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ $child['url'] }}"
                                        class="block px-3 py-2 text-gray-600 hover:text-primary text-sm">
                                        {{ $child['name'] }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-primary block px-3 py-2 text-base font-semibold">
                        {{ $item['name'] }}
                    </a>
                @endif
            @endforeach
            <!-- Catalog link for mobile -->
            <a href="{{ route('catalogs') }}"
                class="text-gray-700 hover:text-primary block px-3 py-2 text-base font-semibold">
                {{ __('home.catalogs') }}
            </a>
        </div>
    </div>
</nav>

<!-- MOBILE SEARCH MODAL -->
<div id="search-modal" class="fixed top-16 left-0 right-0 bg-white shadow-xl border border-gray-200 z-50 hidden mx-4">
    <div class="p-4">
        <div class="flex justify-end mb-2">
            <button id="search-close" class="p-1 text-gray-500 bg-gray-200 hover:bg-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="relative">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="Search for products..." autocomplete="off"
                    class="w-full py-3 pl-10 pr-4 text-base bg-gray-100 border border-gray-300 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-300"
                    id="mobile-search-input">
                <input type="hidden" name="category" id="mobile-selected-category" value="">
                <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <button type="submit" class="hidden">Search</button>
            </form>
        </div>

        <!-- Popular searches (mobile) -->
        <div id="mobile-popular-searches" class="px-3 py-2 mt-2 hidden">
            <p class="text-xs font-medium text-gray-500 mb-2">Popular Searches</p>
            <div id="mobile-popular-loading" class="hidden flex items-center space-x-2">
                <div class="animate-spin h-4 w-4 border-b-2 border-primary"></div>
                <span class="text-sm text-gray-600">Loading popular searches...</span>
            </div>
            <div id="mobile-popular-results" class="flex flex-wrap gap-2">
                @foreach ($topSearchedTerms as $term)
                    <a href="{{ route('search') }}?q={{ urlencode($term->term) }}"
                        class="px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-sm text-gray-700">
                        {{ $term->term }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Search suggestions dropdown (mobile) -->
        <div id="mobile-search-suggestions"
            class="mt-2 bg-white shadow-lg border border-gray-200 hidden max-h-80 overflow-y-auto">
            <div class="p-2">
                <div id="mobile-search-loading" class="hidden px-3 py-2">
                    <div class="flex items-center space-x-2">
                        <div class="animate-spin h-4 w-4 border-b-2 border-primary"></div>
                        <span class="text-sm text-gray-600">Searching...</span>
                    </div>
                </div>
                <div id="mobile-search-empty" class="hidden px-3 py-2 text-sm text-gray-500">No results found.</div>
                <div id="mobile-search-results" class="mt-2"></div>
                <div id="mobile-search-view-all" class="hidden border-t border-gray-100 mt-2 pt-2">
                    <a href="#" id="mobile-search-view-all-link"
                        class="flex items-center justify-center text-primary hover:text-primary-dark font-medium text-sm py-2 px-3 bg-gray-50 hover:bg-gray-100">
                        <span>View all results</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Mobile dropdown toggles
            document.querySelectorAll('.mobile-dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const dropdown = this.nextElementSibling;
                    const arrow = this.querySelector('.mobile-dropdown-arrow');
                    dropdown.classList.toggle('hidden');
                    arrow.classList.toggle('rotate-180');
                });
            });
            document.querySelectorAll('.mobile-subdropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const dropdown = this.nextElementSibling;
                    const arrow = this.querySelector('.mobile-subdropdown-arrow');
                    dropdown.classList.toggle('hidden');
                    arrow.classList.toggle('rotate-180');
                });
            });

            // Categories mega menu
            const categoriesData = @json($categoriesDropdown);

            function initCategoriesMegaMenu(container) {
                const level1Buttons = container.querySelectorAll('.category-level1');
                const level2Container = container.querySelector('.level2-container');
                const level3Container = container.querySelector('.level3-container');

                function renderLevel2(children) {
                    level2Container.innerHTML = '';
                    level2Container.classList.remove('hidden');
                    level3Container.classList.add('hidden');

                    children.forEach(child => {
                        const link = document.createElement('a');
                        link.href = child.url;
                        link.className =
                            'w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary flex justify-between items-center category-selectable';
                        link.setAttribute('data-id', child.id);
                        link.setAttribute('data-name', child.name);
                        link.setAttribute('data-slug', child.slug);
                        link.innerHTML =
                            `<span class="truncate">${child.name}</span>
            ${child.has_children ? '<svg class="w-4 h-4 transition-transform duration-200 group-hover:-rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>' : ''}`;
                        link.addEventListener('mouseenter', () => {
                            if (child.children && child.children.length) {
                                renderLevel3(child.children);
                            } else {
                                level3Container.classList.add('hidden');
                            }
                        });
                        level2Container.appendChild(link);
                    });
                }

                function renderLevel3(children) {
                    level3Container.innerHTML = '';
                    level3Container.classList.remove('hidden');

                    children.forEach(grandchild => {
                        const link = document.createElement('a');
                        link.href = grandchild.url;
                        link.className =
                            'block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary truncate category-selectable';
                        link.setAttribute('data-id', grandchild.id);
                        link.setAttribute('data-name', grandchild.name);
                        link.setAttribute('data-slug', grandchild.slug);
                        link.textContent = grandchild.name;
                        level3Container.appendChild(link);
                    });
                }

                level1Buttons.forEach(btn => {
                    btn.addEventListener('mouseenter', function() {
                        const id = this.dataset.id;
                        const category = categoriesData.find(c => c.id == id);
                        if (!category || !category.children || category.children.length === 0) {
                            level2Container.classList.add('hidden');
                            level3Container.classList.add('hidden');
                            return;
                        }
                        renderLevel2(category.children);
                    });
                });

                container.addEventListener('mouseleave', () => {
                    level2Container.classList.add('hidden');
                    level3Container.classList.add('hidden');
                });
            }

            document.querySelectorAll('.categories-mega-menu').forEach(initCategoriesMegaMenu);

            // Category selection
            const allCategoriesBtn = document.getElementById('all-categories-btn');
            const selectedCategoryText = document.getElementById('selected-category-text');
            const desktopSelectedCategory = document.getElementById('desktop-selected-category');
            const mobileSelectedCategory = document.getElementById('mobile-selected-category');

            // Handle click on any selectable category
            document.addEventListener('click', function(e) {
                const selectable = e.target.closest('.category-selectable');
                if (!selectable) return;

                e.preventDefault(); // Prevent navigation

                const categoryId = selectable.dataset.id;
                const categoryName = selectable.dataset.name;
                const categorySlug = selectable.dataset.slug;

                // Update button text
                selectedCategoryText.textContent = categoryName;

                // Update hidden inputs
                if (desktopSelectedCategory) desktopSelectedCategory.value = categoryId;
                if (mobileSelectedCategory) mobileSelectedCategory.value = categoryId;

                // Close the mega menu after selection
                const megaMenu = selectable.closest('.categories-mega-menu');
                if (megaMenu) {
                    megaMenu.classList.add('invisible', 'opacity-0');
                }
            });

            // Reset selection when clicking "All Categories" button
            allCategoriesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                selectedCategoryText.textContent = 'All Categories';
                if (desktopSelectedCategory) desktopSelectedCategory.value = '';
                if (mobileSelectedCategory) mobileSelectedCategory.value = '';
            });

            // Desktop search
            const desktopSearchInput = document.getElementById('desktop-search-input');
            const desktopSuggestions = document.getElementById('desktop-search-suggestions');
            const desktopPopular = document.getElementById('desktop-popular-searches');
            const desktopPopularResults = document.getElementById('desktop-popular-results');
            const desktopPopularLoading = document.getElementById('desktop-popular-loading');
            const desktopSearchLoading = document.getElementById('desktop-search-loading');
            const desktopSearchEmpty = document.getElementById('desktop-search-empty');
            const desktopSearchResults = document.getElementById('desktop-search-results');
            const desktopSearchViewAll = document.getElementById('desktop-search-view-all');
            const desktopSearchViewAllLink = document.getElementById('desktop-search-view-all-link');

            let desktopSearchTimeout;
            let desktopAbortController = null;

            function hideDesktopSuggestions() {
                desktopSuggestions.classList.add('hidden');
            }

            function showDesktopSuggestions() {
                desktopSuggestions.classList.remove('hidden');
            }

            function fetchDesktopSuggestions(query) {
                if (query.length < 2) return;

                desktopSearchLoading.classList.remove('hidden');
                desktopSearchEmpty.classList.add('hidden');
                desktopSearchViewAll.classList.add('hidden');
                desktopSearchResults.innerHTML = '';
                showDesktopSuggestions();

                if (desktopAbortController) desktopAbortController.abort();
                desktopAbortController = new AbortController();

                fetch(`{{ route('search.suggest') }}?q=${encodeURIComponent(query)}`, {
                        signal: desktopAbortController.signal,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        desktopSearchLoading.classList.add('hidden');
                        if (data.length === 0) {
                            desktopSearchEmpty.classList.remove('hidden');
                            return;
                        }
                        displayDesktopResults(data, query);
                    })
                    .catch(err => {
                        if (err.name !== 'AbortError') {
                            desktopSearchLoading.classList.add('hidden');
                            desktopSearchEmpty.classList.remove('hidden');
                        }
                    });
            }

            function displayDesktopResults(results, query) {
                desktopSearchResults.innerHTML = '';
                results.forEach(result => {
                    const div = document.createElement('div');
                    div.className = 'px-4 py-3 hover:bg-gray-50 cursor-pointer border-b last:border-b-0';
                    div.setAttribute('data-url', result.url);
                    if (result.type === 'product') {
                        div.innerHTML = `
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-100 overflow-hidden">
                                ${result.image ? `<img src="${result.image}" class="w-full h-full object-cover">` : ''}
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 mb-1">${result.highlight}</div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-primary font-semibold"><span class="font-bengali">৳</span>${result.price}</span>
                                    ${result.in_stock ? '<span class="text-xs text-green-600 bg-green-50 px-2 py-1">In Stock</span>' : '<span class="text-xs text-red-600 bg-red-50 px-2 py-1">Out of Stock</span>'}
                                </div>
                            </div>
                        </div>
                    `;
                    } else {
                        div.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-blue-50">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                            </div>
                            <div class="text-sm font-medium text-gray-900">${result.highlight} <span class="text-xs text-gray-500 ml-2">Category</span></div>
                        </div>
                    `;
                    }
                    div.addEventListener('click', function() {
                        window.location.href = this.dataset.url;
                    });
                    desktopSearchResults.appendChild(div);
                });
                desktopSearchViewAllLink.href = `{{ route('search') }}?q=${encodeURIComponent(query)}`;
                desktopSearchViewAll.classList.remove('hidden');
            }

            desktopSearchInput.addEventListener('focus', () => {
                showDesktopSuggestions();
                if (desktopSearchInput.value.trim() === '') {
                    desktopPopular.classList.remove('hidden');
                } else {
                    desktopPopular.classList.add('hidden');
                }
            });

            desktopSearchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length >= 2) {
                    desktopPopular.classList.add('hidden');
                    clearTimeout(desktopSearchTimeout);
                    desktopSearchTimeout = setTimeout(() => fetchDesktopSuggestions(query), 300);
                } else {
                    desktopPopular.classList.remove('hidden');
                    desktopSearchLoading.classList.add('hidden');
                    desktopSearchEmpty.classList.add('hidden');
                    desktopSearchResults.innerHTML = '';
                    desktopSearchViewAll.classList.add('hidden');
                }
            });

            document.addEventListener('click', function(e) {
                if (!desktopSearchInput?.contains(e.target) && !desktopSuggestions?.contains(e.target)) {
                    hideDesktopSuggestions();
                }
            });

            desktopSuggestions?.addEventListener('click', (e) => e.stopPropagation());

            // Mobile search modal
            const mobileSearchToggle = document.getElementById('mobile-search-toggle');
            const searchModal = document.getElementById('search-modal');
            const searchClose = document.getElementById('search-close');
            const mobileSearchInput = document.getElementById('mobile-search-input');
            const mobilePopular = document.getElementById('mobile-popular-searches');
            const mobilePopularResults = document.getElementById('mobile-popular-results');
            const mobilePopularLoading = document.getElementById('mobile-popular-loading');
            const mobileSearchLoading = document.getElementById('mobile-search-loading');
            const mobileSearchEmpty = document.getElementById('mobile-search-empty');
            const mobileSearchResults = document.getElementById('mobile-search-results');
            const mobileSearchViewAll = document.getElementById('mobile-search-view-all');
            const mobileSearchViewAllLink = document.getElementById('mobile-search-view-all-link');

            let mobileSearchTimeout;
            let mobileAbortController = null;

            function openSearchModal() {
                searchModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(() => mobileSearchInput.focus(), 100);
                mobilePopular.classList.remove('hidden');
            }

            function closeSearchModal() {
                searchModal.classList.add('hidden');
                document.body.style.overflow = '';
                mobileSearchInput.value = '';
                document.getElementById('mobile-search-suggestions').classList.add('hidden');
                mobilePopular.classList.add('hidden');
            }

            mobileSearchToggle.addEventListener('click', openSearchModal);
            searchClose.addEventListener('click', closeSearchModal);

            mobileSearchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length >= 2) {
                    mobilePopular.classList.add('hidden');
                    clearTimeout(mobileSearchTimeout);
                    mobileSearchTimeout = setTimeout(() => {
                        const sugg = document.getElementById('mobile-search-suggestions');
                        sugg.classList.remove('hidden');
                        mobileSearchLoading.classList.remove('hidden');
                        mobileSearchEmpty.classList.add('hidden');
                        mobileSearchResults.innerHTML = '';
                        mobileSearchViewAll.classList.add('hidden');

                        if (mobileAbortController) mobileAbortController.abort();
                        mobileAbortController = new AbortController();

                        fetch(`{{ route('search.suggest') }}?q=${encodeURIComponent(query)}`, {
                                signal: mobileAbortController.signal,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                mobileSearchLoading.classList.add('hidden');
                                if (data.length === 0) {
                                    mobileSearchEmpty.classList.remove('hidden');
                                    return;
                                }
                                mobileSearchResults.innerHTML = '';
                                data.forEach(result => {
                                    const div = document.createElement('div');
                                    div.className =
                                        'px-4 py-3 hover:bg-gray-50 cursor-pointer border-b last:border-b-0';
                                    div.setAttribute('data-url', result.url);
                                    if (result.type === 'product') {
                                        div.innerHTML = `
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-12 h-12 bg-gray-100 overflow-hidden">
                                                ${result.image ? `<img src="${result.image}" class="w-full h-full object-cover">` : ''}
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-900 mb-1">${result.highlight}</div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm text-primary font-semibold"><span class="font-bengali">৳</span>${result.price}</span>
                                                    ${result.in_stock ? '<span class="text-xs text-green-600 bg-green-50 px-2 py-1">In Stock</span>' : '<span class="text-xs text-red-600 bg-red-50 px-2 py-1">Out of Stock</span>'}
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    } else {
                                        div.innerHTML = `
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-blue-50">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">${result.highlight} <span class="text-xs text-gray-500 ml-2">Category</span></div>
                                        </div>
                                    `;
                                    }
                                    div.addEventListener('click', function() {
                                        window.location.href = this.dataset.url;
                                        closeSearchModal();
                                    });
                                    mobileSearchResults.appendChild(div);
                                });
                                mobileSearchViewAllLink.href =
                                    `{{ route('search') }}?q=${encodeURIComponent(query)}`;
                                mobileSearchViewAll.classList.remove('hidden');
                            })
                            .catch(err => {
                                if (err.name !== 'AbortError') {
                                    mobileSearchLoading.classList.add('hidden');
                                    mobileSearchEmpty.classList.remove('hidden');
                                }
                            });
                    }, 300);
                } else {
                    document.getElementById('mobile-search-suggestions').classList.add('hidden');
                    mobilePopular.classList.remove('hidden');
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !searchModal.classList.contains('hidden')) {
                    closeSearchModal();
                }
            });
        });
    </script>
@endpush
