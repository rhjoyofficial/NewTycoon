<!-- Sidebar -->
<div class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 border-r border-gray-700 flex flex-col flex-shrink-0 shadow-xl no-scrollbar"
    x-data="{
        activeGroup: null,
        init() {
            // Set active group based on current route
            @if (request()->routeIs('admin.users.*')) this.activeGroup = 'users';
            @elseif(request()->routeIs('admin.products.*'))
                this.activeGroup = 'products';
            @elseif(request()->routeIs('admin.categories.*'))
                this.activeGroup = 'categories';
            @elseif(request()->routeIs('admin.content.*') || request()->routeIs('admin.hero-slides.*'))
                this.activeGroup = 'content';
            @elseif(request()->routeIs('admin.orders.*'))
                this.activeGroup = 'orders';
            @elseif(request()->routeIs('admin.offers.*'))
                this.activeGroup = 'offers';
            @elseif(request()->routeIs('admin.settings.*'))
                this.activeGroup = 'settings'; @endif
        }
    }" id="sidebar">

    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="group flex flex-col items-center">
            <img src="{{ asset('images/wh-logo.png') }}" alt="Azmion Admin Logo" loading="lazy" class="h-8 w-auto">

            <span
                class="mt-1 text-xs tracking-wide text-gray-400 group-hover:text-gray-200 transition-colors duration-300">
                Admin Panel
            </span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-3 overflow-y-auto no-scrollbar">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
            <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="ml-3 font-inter">Dashboard</span>
        </a>

        <!-- Users -->
        @if (auth()->user()->hasPermission('manage_users'))
            <div x-data="{ open: activeGroup === 'users' }">
                <button @click="open = !open; activeGroup = open ? 'users' : null"
                    class="w-full group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ml-3 font-inter flex-1 text-left">Users</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.users.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.index') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.users.index') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        All Users
                    </a>
                    <a href="{{ route('admin.users.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.create') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.users.create') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add User
                    </a>
                </div>
            </div>
        @endif

        <!-- Products -->
        @if (auth()->user()->hasPermission('manage_products'))
            <div x-data="{ open: activeGroup === 'products' }">
                <button @click="open = !open; activeGroup = open ? 'products' : null"
                    class="w-full group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.products.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.products.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="ml-3 font-inter flex-1 text-left">Products</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.products.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.index') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.products.index') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        All Products
                    </a>
                    <a href="{{ route('admin.products.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.create') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.products.create') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>
        @endif

        <!-- Brands -->
        @if (auth()->user()->hasPermission('manage_brands'))
            {{-- {{ route('admin.brands.index') }} --}}
            <a href="javascript:void(0);"
                class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.brands.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.brands.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span class="ml-3 font-inter">Brands</span>
            </a>
        @endif

        <!-- Categories -->
        @if (auth()->user()->hasPermission('manage_products'))
            <div x-data="{ open: activeGroup === 'categories' }">
                <button @click="open = !open; activeGroup = open ? 'categories' : null"
                    class="w-full group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.categories.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.categories.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="ml-3 font-inter flex-1 text-left">Categories</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.categories.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.categories.index') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.categories.index') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        All Categories
                    </a>
                    <a href="{{ route('admin.categories.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.categories.create') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.categories.create') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Category
                    </a>
                </div>
            </div>
        @endif

        <!-- Content -->
        @if (auth()->user()->hasPermission('manage_content'))
            <div x-data="{ open: activeGroup === 'content' }">
                <button @click="open = !open; activeGroup = open ? 'content' : null"
                    class="w-full group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.content.*', 'admin.hero-slides.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.content.*', 'admin.hero-slides.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <span class="ml-3 font-inter flex-1 text-left">Content</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <!-- Hero Slides -->
                    <a href="{{ route('admin.hero-slides.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.hero-slides.*') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.hero-slides.*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Hero Slides
                    </a>

                    <!-- Ad Banners -->
                    <a href="{{ route('admin.content.ad-banners.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.content.ad-banners.*') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.content.ad-banners.*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Ad Banners
                    </a>

                    <!-- Sections -->
                    <a href="{{ route('admin.content.sections.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.content.sections.*') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.content.sections.*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Sections
                    </a>

                    <!-- Add more content management links here as needed -->
                    {{-- <a href="javascript:void(0);"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors text-gray-400 hover:text-white hover:bg-gray-700/30">
                        <svg class="mr-3 h-4 w-4 text-gray-500 group-hover:text-primary"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Pages
                    </a> --}}
                </div>
            </div>
        @endif

        <!-- Orders -->
        @if (auth()->user()->hasPermission('no_permissions'))
            <div x-data="{ open: activeGroup === 'orders' }">
                <button @click="open = !open; activeGroup = open ? 'orders' : null"
                    class="w-full group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.orders.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.orders.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="ml-3 font-inter flex-1 text-left">Orders</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.orders.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.index') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.orders.index') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        All Orders
                    </a>
                    <a href="{{ route('admin.orders.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.create') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.orders.create') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Order
                    </a>
                </div>
            </div>
        @endif

        <!-- Offers -->
        @if (auth()->user()->hasPermission('no_permissions'))
            <div x-data="{ open: activeGroup === 'offers' }">
                <button @click="open = !open; activeGroup = open ? 'offers' : null"
                    class="w-full group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.offers.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.offers.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="ml-3 font-inter flex-1 text-left">Offers</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.offers.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.offers.index') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.offers.index') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        All Offers
                    </a>
                    <a href="{{ route('admin.offers.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.offers.create') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.offers.create') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Offer
                    </a>
                </div>
            </div>
        @endif

        <!-- Analytics -->
        @if (auth()->user()->hasPermission('no_permissions'))
            <a href="{{ route('admin.analytics.index') }}"
                class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.analytics.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.analytics.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="ml-3 font-inter">Analytics</span>
            </a>
        @endif

        <!-- Settings -->
        @if (auth()->user()->hasPermission('no_permissions'))
            <div x-data="{ open: activeGroup === 'settings' }">
                <button @click="open = !open; activeGroup = open ? 'settings' : null"
                    class="w-full group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.settings.*') ? 'bg-primary/20 text-white border-l-4 border-primary' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }}">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="ml-3 font-inter flex-1 text-left">Settings</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    {{-- <a href="{{ route('admin.settings.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.settings.index') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.settings.index') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        General Settings
                    </a> --}}
                    <a href="{{ route('admin.footer.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.footer.*') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.footer.*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Footer & Social Links
                    </a>
                    <a href="{{ route('admin.settings.roles.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.settings.roles.*') ? 'bg-primary/10 text-primary' : 'text-gray-400 hover:text-white hover:bg-gray-700/30' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.settings.roles.*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Roles & Permissions
                    </a>
                </div>
            </div>
        @endif

        <!-- Quick Actions Section -->
        <div class="pt-6 mt-6 border-t border-gray-700">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Actions</p>
            <div class="space-y-2">
                @if (auth()->user()->hasPermission('manage_users'))
                    <a href="{{ route('admin.users.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:text-white hover:bg-gray-700/50">
                        <div
                            class="h-8 w-8 rounded-lg bg-primary/20 flex items-center justify-center mr-3 group-hover:bg-primary/30 transition-colors">
                            <i class="fas fa-user-plus text-primary text-sm"></i>
                        </div>
                        Add User
                    </a>
                @endif

                @if (auth()->user()->hasPermission('manage_products'))
                    <a href="{{ route('admin.products.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:text-white hover:bg-gray-700/50">
                        <div
                            class="h-8 w-8 rounded-lg bg-primary/20 flex items-center justify-center mr-3 group-hover:bg-primary/30 transition-colors">
                            <i class="fas fa-plus-circle text-primary text-sm"></i>
                        </div>
                        Add Product
                    </a>
                @endif

                @if (auth()->user()->hasPermission('manage_content'))
                    <a href="{{ route('admin.hero-slides.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:text-white hover:bg-gray-700/50">
                        <div
                            class="h-8 w-8 rounded-lg bg-primary/20 flex items-center justify-center mr-3 group-hover:bg-primary/30 transition-colors">
                            <i class="fas fa-image text-primary text-sm"></i>
                        </div>
                        Add Hero Slide
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- User Profile -->
    <div class="border-t border-gray-700 p-4 bg-gray-800/50">
        <div class="flex items-center">
            <div
                class="h-10 w-10 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center shadow-lg">
                <span
                    class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-300 truncate">
                    @if (Auth::user()->isAdmin())
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary/20 text-primary">
                            Administrator
                        </span>
                    @elseif(Auth::user()->isModerator())
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-500/20 text-blue-300">
                            Moderator
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-500/20 text-gray-300">
                            User
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>

</div>
