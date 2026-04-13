@extends('admin.layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Offer</h1>
                        <p class="mt-2 text-sm text-gray-600">Update offer details and settings</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.offers.index') }}"
                            class="px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                            Cancel
                        </a>
                        <button type="submit" form="offerForm"
                            class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white text-sm font-medium rounded-xl hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                            Update Offer
                        </button>
                    </div>
                </div>
            </div>

            <form id="offerForm" action="{{ route('admin.offers.update', $offer) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Main Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Basic Information Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                                <p class="text-sm text-gray-600 mt-1">Enter offer title, description, and banner</p>
                            </div>

                            <div class="p-6 space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                        Title <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="title" name="title" required
                                        value="{{ old('title', $offer->title) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors @error('title') border-red-300 @enderror"
                                        placeholder="e.g., Summer Sale 2024">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Subtitle -->
                                <div>
                                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">
                                        Subtitle
                                    </label>
                                    <textarea id="subtitle" name="subtitle" rows="2"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors @error('subtitle') border-red-300 @enderror"
                                        placeholder="Brief description of the offer">{{ old('subtitle', $offer->subtitle) }}</textarea>
                                    @error('subtitle')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Main Banner Image -->
                                <div>
                                    <label for="main_banner_image" class="block text-sm font-medium text-gray-700 mb-1">
                                        Main Banner Image
                                    </label>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-1">
                                            <input type="file" id="main_banner_image" name="main_banner_image"
                                                accept="image/*"
                                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                        </div>
                                        @if ($offer->main_banner_image)
                                            <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-200">
                                                <img src="{{ $offer->main_banner_url }}" alt="Banner"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Product showcase image, Max 5MB. Leave empty to
                                        keep current.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Product Source Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                <h2 class="text-lg font-semibold text-gray-900">Product Selection</h2>
                                <p class="text-sm text-gray-600 mt-1">Configure how products are selected for this offer</p>
                            </div>

                            <div class="p-6 space-y-6">
                                <!-- Source Type -->
                                <div>
                                    <label for="product_source" class="block text-sm font-medium text-gray-700 mb-3">
                                        Source Type <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        @foreach (['manual' => 'Manual Selection', 'discount' => 'Auto - By Discount', 'category' => 'Auto - By Category'] as $value => $label)
                                            <label
                                                class="relative flex flex-col items-center justify-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:border-primary hover:bg-primary/5 sourceOption {{ old('product_source', $offer->product_source) === $value ? 'border-primary bg-primary/10' : 'border-gray-200' }}">
                                                <input type="radio" name="product_source" value="{{ $value }}"
                                                    class="sr-only"
                                                    {{ old('product_source', $offer->product_source) === $value ? 'checked' : '' }}>
                                                @if ($value === 'manual')
                                                    <svg class="w-8 h-8 text-gray-700 mb-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                @elseif($value === 'discount')
                                                    <svg class="w-8 h-8 text-gray-700 mb-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-8 h-8 text-gray-700 mb-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                @endif
                                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Dynamic Fields -->
                                <div id="sourceFields">
                                    <!-- Manual Products -->
                                    <div id="manual-products"
                                        class="{{ old('product_source', $offer->product_source) === 'manual' ? '' : 'hidden' }}">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Select Products
                                        </label>
                                        <select name="products[]" multiple
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            size="6">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ in_array($product->id, old('products', $selectedProducts ?? [])) ? 'selected' : '' }}>
                                                    {{ $product->name }} - ৳{{ number_format($product->price, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple products</p>
                                    </div>

                                    <!-- Discount Config -->
                                    <div id="discount-config"
                                        class="{{ old('product_source', $offer->product_source) === 'discount' ? '' : 'hidden' }}">
                                        <label for="min_discount" class="block text-sm font-medium text-gray-700 mb-1">
                                            Minimum Discount Percentage
                                        </label>
                                        <div class="flex items-center space-x-3">
                                            <input type="range" id="min_discount" name="source_config[min_discount]"
                                                min="1" max="100"
                                                value="{{ old('source_config.min_discount', $offer->source_config['min_discount'] ?? 10) }}"
                                                class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                            <div class="w-20">
                                                <input type="number" id="min_discount_input" min="1"
                                                    max="100"
                                                    value="{{ old('source_config.min_discount', $offer->source_config['min_discount'] ?? 10) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-center">
                                            </div>
                                            <span class="text-gray-500">%</span>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Products with at least this discount will be
                                            included</p>
                                    </div>

                                    <!-- Category Config -->
                                    <div id="category-config"
                                        class="{{ old('product_source', $offer->product_source) === 'category' ? '' : 'hidden' }}">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Select Categories
                                        </label>
                                        <select name="source_config[category_ids][]" multiple
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            size="5">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, old('source_config.category_ids', $offer->source_config['category_ids'] ?? [])) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @foreach ($category->children as $child)
                                                    <option value="{{ $child->id }}"
                                                        {{ in_array($child->id, old('source_config.category_ids', $offer->source_config['category_ids'] ?? [])) ? 'selected' : '' }}>
                                                        &nbsp;&nbsp;→ {{ $child->name }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <p class="mt-1 text-xs text-gray-500">Products from selected categories will be
                                            included</p>
                                    </div>
                                </div>

                                <!-- Product Limit -->
                                <div>
                                    <label for="product_limit" class="block text-sm font-medium text-gray-700 mb-1">
                                        Product Limit <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="product_limit" name="product_limit" min="1"
                                        max="100" required value="{{ old('product_limit', $offer->product_limit) }}"
                                        class="w-32 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <p class="mt-1 text-xs text-gray-500">Maximum number of products to display (1-100)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Settings -->
                    <div class="space-y-8">
                        <!-- Settings Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                <h2 class="text-lg font-semibold text-gray-900">Settings</h2>
                                <p class="text-sm text-gray-600 mt-1">Configure offer visibility and timing</p>
                            </div>

                            <div class="p-6 space-y-6">
                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" name="status" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                        @foreach (['draft' => 'Draft', 'active' => 'Active', 'inactive' => 'Inactive', 'scheduled' => 'Scheduled'] as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('status', $offer->status) === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Timer -->
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="timer_enabled" name="timer_enabled" value="1"
                                            {{ old('timer_enabled', $offer->timer_enabled) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary/20">
                                        <label for="timer_enabled" class="ml-2 text-sm font-medium text-gray-700">
                                            Enable Countdown Timer
                                        </label>
                                    </div>

                                    <div id="timerFields"
                                        class="{{ old('timer_enabled', $offer->timer_enabled) ? '' : 'hidden' }}">
                                        <label for="timer_end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                            Timer End Date
                                        </label>
                                        <input type="datetime-local" id="timer_end_date" name="timer_end_date"
                                            value="{{ old('timer_end_date', $offer->timer_end_date ? $offer->timer_end_date->format('Y-m-d\TH:i') : '') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    </div>
                                </div>

                                <!-- Schedule -->
                                <div class="space-y-4">
                                    <h3 class="text-sm font-medium text-gray-900">Schedule</h3>

                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                            Start Date
                                        </label>
                                        <input type="datetime-local" id="start_date" name="start_date"
                                            value="{{ old('start_date', $offer->start_date ? $offer->start_date->format('Y-m-d\TH:i') : '') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    </div>

                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                            End Date
                                        </label>
                                        <input type="datetime-local" id="end_date" name="end_date"
                                            value="{{ old('end_date', $offer->end_date ? $offer->end_date->format('Y-m-d\TH:i') : '') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    </div>
                                </div>

                                <!-- Display Order -->
                                <div>
                                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                                        Display Order
                                    </label>
                                    <input type="number" id="order" name="order"
                                        value="{{ old('order', $offer->order) }}"
                                        class="w-32 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                                </div>

                                <!-- View All Link -->
                                <div>
                                    <label for="view_all_link" class="block text-sm font-medium text-gray-700 mb-1">
                                        View All Link
                                    </label>
                                    <input type="text" id="view_all_link" name="view_all_link"
                                        value="{{ old('view_all_link', $offer->view_all_link) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="products.index or /shop">
                                </div>

                                <!-- View All Text -->
                                <div>
                                    <label for="view_all_text" class="block text-sm font-medium text-gray-700 mb-1">
                                        View All Text
                                    </label>
                                    <input type="text" id="view_all_text" name="view_all_text"
                                        value="{{ old('view_all_text', $offer->view_all_text ?? 'View All') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Button text for view all link">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="space-y-3">
                                    <button type="submit"
                                        class="w-full px-6 py-3.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        Update Offer
                                    </button>

                                    <a href="{{ route('admin.offers.index') }}"
                                        class="w-full px-6 py-3.5 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Card -->
                        @if (isset($offer))
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                    <h2 class="text-lg font-semibold text-gray-900">Quick Stats</h2>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                                            <div class="text-2xl font-bold text-gray-900">
                                                {{ number_format($offer->view_count) }}</div>
                                            <div class="text-sm text-gray-600 mt-1">Views</div>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                                            <div class="text-2xl font-bold text-gray-900">
                                                {{ number_format($offer->click_count) }}</div>
                                            <div class="text-sm text-gray-600 mt-1">Clicks</div>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                                            <div class="text-2xl font-bold text-gray-900">{{ $offer->products_count }}
                                            </div>
                                            <div class="text-sm text-gray-600 mt-1">Products</div>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                                            <div class="text-lg font-bold text-gray-900">
                                                {{ ucfirst($offer->product_source) }}</div>
                                            <div class="text-sm text-gray-600 mt-1">Source</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Source Type Toggle
            const sourceOptions = document.querySelectorAll('input[name="product_source"]');

            function toggleSourceFields() {
                const selected = document.querySelector('input[name="product_source"]:checked').value;

                // Hide all fields
                document.querySelectorAll('#sourceFields > div').forEach(field => {
                    field.classList.add('hidden');
                });

                // Show selected field
                document.getElementById(selected === 'manual' ? 'manual-products' : (selected === 'discount' ?
                    'discount-config' : 'category-config')).classList.remove('hidden');

                // Update visual selection
                document.querySelectorAll('.sourceOption').forEach(option => {
                    option.classList.remove('border-primary', 'bg-primary/10');
                    option.classList.add('border-gray-200');
                });

                const selectedOption = document.querySelector(`input[name="product_source"][value="${selected}"]`)
                    .parentElement;
                selectedOption.classList.remove('border-gray-200');
                selectedOption.classList.add('border-primary', 'bg-primary/10');
            }

            sourceOptions.forEach(option => {
                option.addEventListener('change', toggleSourceFields);
            });

            // Timer Toggle
            const timerEnabled = document.getElementById('timer_enabled');
            const timerFields = document.getElementById('timerFields');

            timerEnabled.addEventListener('change', function() {
                if (this.checked) {
                    timerFields.classList.remove('hidden');
                } else {
                    timerFields.classList.add('hidden');
                }
            });

            // Discount Range Sync
            const discountRange = document.getElementById('min_discount');
            const discountInput = document.getElementById('min_discount_input');

            if (discountRange && discountInput) {
                discountRange.addEventListener('input', function() {
                    discountInput.value = this.value;
                });

                discountInput.addEventListener('input', function() {
                    discountRange.value = this.value;
                });
            }
        });
    </script>
@endsection
