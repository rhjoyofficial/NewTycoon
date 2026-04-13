<!-- Topbar -->
<header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-40">
    <div class="flex items-center justify-between h-16 px-6">
        <!-- Left Section -->
        <div class="flex items-center space-x-4 ">

            <!-- Page Title -->
            <div>
                <h1 class="text-xl font-cambay font-bold text-gray-900">
                    @hasSection('page-title')
                        @yield('page-title')
                    @else
                        Dashboard
                    @endif
                </h1>
                @hasSection('page-description')
                    <p class="text-sm text-gray-500 mt-1">@yield('page-description')</p>
                @endif
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="relative hidden lg:block">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="search"
                    class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent w-64 bg-gray-50 focus:bg-white transition-all duration-300 font-inter"
                    placeholder="Search orders, products, users...">
            </div>

            <!-- Notifications -->
            <div class="relative">
                <button @click="$dispatch('toggle-notifications')"
                    class="p-2.5 rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 relative">
                    <i class="fas fa-bell text-gray-600 text-lg"></i>
                    <span class="absolute top-2 right-2 h-2 w-2 bg-primary rounded-full animate-pulse"></span>
                </button>
            </div>

            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-300">
                    <div
                        class="h-9 w-9 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center shadow-md">
                        <span class="text-white font-semibold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="hidden lg:block text-left">
                        <p class="text-sm font-medium text-gray-900 font-inter">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 font-inter">
                            @if (Auth::user()->isAdmin())
                                Administrator
                            @elseif(Auth::user()->isModerator())
                                Moderator
                            @else
                                User
                            @endif
                        </p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300"
                        :class="{ 'transform rotate-180': open }"></i>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95" x-cloak
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <a href="{{ route('admin.profile.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-user-circle mr-3 text-gray-400"></i>
                        My Profile
                    </a>

                    {{-- @if (auth()->user()->hasPermission('manage_settings'))
                        <a href="{{ route('admin.settings.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-cog mr-3 text-gray-400"></i>
                            Settings
                        </a>
                    @endif --}}

                    <a href="{{ route('home') }}" target="_blank"
                        class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200 border-t border-gray-100">
                        <i class="fas fa-external-link-alt mr-3 text-gray-400"></i>
                        View Website
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200 border-t border-gray-100">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Search (hidden on desktop) -->
<div class="lg:hidden px-4 py-3 bg-gray-50 border-b border-gray-100" x-data="{ showMobileSearch: false }">
    <div class="relative" x-show="showMobileSearch" x-transition>
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-search text-gray-400"></i>
        </div>
        <input type="search"
            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white font-inter"
            placeholder="Search...">
    </div>
    <button @click="showMobileSearch = !showMobileSearch" x-show="!showMobileSearch"
        class="w-full text-left text-gray-500 hover:text-gray-700">
        <i class="fas fa-search mr-2"></i> Search...
    </button>
</div>

<!-- Notifications Panel -->
<div x-data="{ showNotifications: false }" @toggle-notifications.window="showNotifications = !showNotifications"
    x-show="showNotifications" @click.away="showNotifications = false" x-transition x-cloak
    class="absolute right-4 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-3 z-50">
    <div class="px-4 pb-3 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
            <button class="text-xs text-primary hover:text-primary-dark font-medium">
                Mark all as read
            </button>
        </div>
    </div>

    <!-- Notification items would go here -->
    <div class="px-4 py-8 text-center">
        <i class="fas fa-bell-slash text-gray-300 text-3xl mb-3"></i>
        <p class="text-gray-500 text-sm">No new notifications</p>
    </div>

    <a href="#"
        class="block text-center px-4 py-2 text-sm text-primary hover:text-primary-dark font-medium border-t border-gray-100">
        View all notifications
    </a>
</div>
