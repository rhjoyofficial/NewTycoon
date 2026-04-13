@extends('admin.layouts.app')

@section('title', 'Add New Product')
@section('page-title', 'Add Product')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.products.index') }}" class="text-primary hover:text-primary/80">Products</a>
    </li>
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Add New</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Add New Product</h1>
                    <p class="mt-1 text-sm text-gray-600">Fill in the details below to create a new product</p>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Products
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="rounded-lg bg-red-50 border border-red-200 p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please fix the errors below</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                data-form novalidate>
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column: Basic Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500"><span class="text-primary">*</span> Required
                                        fields</span>
                                    <button type="submit" data-loading data-loading-text="Creating..."
                                        class="px-4 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        Create Product
                                    </button>
                                </div>

                            </div>

                            <div class="space-y-6">
                                <!-- Name & Category - 2 per row -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name_en" class="block text-sm font-medium text-gray-700 mb-1">
                                            Product Name (English) <span class="text-primary">*</span>
                                        </label>
                                        <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('name_en') border-red-300 @enderror"
                                            required maxlength="255" placeholder="Enter product name in English">
                                        @error('name_en')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="name_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                            Product Name (Bengali)
                                        </label>
                                        <input type="text" name="name_bn" id="name_bn" value="{{ old('name_bn') }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('name_bn') border-red-300 @enderror"
                                            maxlength="255" placeholder="বাংলায় পণ্যের নাম লিখুন">
                                        @error('name_bn')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            Category <span class="text-primary">*</span>
                                        </label>
                                        <select name="category_id" id="category_id"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('category_id') border-red-300 @enderror"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->full_name }}
                                                    {{-- @if ($category->name_bn)
                                                        ({{ $category->name_bn }})
                                                    @endif --}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- SKU Field -->
                                    <div>
                                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">
                                            SKU
                                        </label>
                                        <div class="flex gap-2">
                                            <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                                class="flex-1 rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('sku') border-red-300 @enderror"
                                                maxlength="50" placeholder="Auto-generated if empty">
                                            <button type="button" id="generateSku"
                                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                Generate
                                            </button>
                                        </div>
                                        @error('sku')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-primary">Leave empty for auto-generation</p>
                                    </div>
                                </div>

                                <!-- Model Number & Slug -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="model_number" class="block text-sm font-medium text-gray-700 mb-1">
                                            Model Number
                                        </label>
                                        <input type="text" name="model_number" id="model_number"
                                            value="{{ old('model_number') }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('model_number') border-red-300 @enderror"
                                            maxlength="100" placeholder="Optional model number">
                                        @error('model_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                                            Custom Slug
                                        </label>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('slug') border-red-300 @enderror"
                                            maxlength="255" placeholder="Auto-generated from English name">
                                        @error('slug')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Leave empty for auto-generation</p>
                                    </div>
                                </div>

                                <!-- Descriptions -->
                                <div class="space-y-4">
                                    <!-- Short Description -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="short_description_en"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Short Description (English)
                                            </label>
                                            <textarea name="short_description_en" id="short_description_en" rows="2"
                                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('short_description_en') border-red-300 @enderror"
                                                maxlength="500" placeholder="Brief product description in English">{{ old('short_description_en') }}</textarea>
                                            @error('short_description_en')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-xs text-gray-500">Maximum 500 characters</p>
                                        </div>

                                        <div>
                                            <label for="short_description_bn"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Short Description (Bengali)
                                            </label>
                                            <textarea name="short_description_bn" id="short_description_bn" rows="2"
                                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('short_description_bn') border-red-300 @enderror"
                                                maxlength="500" placeholder="বাংলায় সংক্ষিপ্ত বিবরণ">{{ old('short_description_bn') }}</textarea>
                                            @error('short_description_bn')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-xs text-gray-500">সর্বোচ্চ ৫০০ অক্ষর</p>
                                        </div>
                                    </div>

                                    <!-- Full Description -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="description_en"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Description (English) <span class="text-primary">*</span>
                                            </label>
                                            <textarea name="description_en" id="description_en" rows="4"
                                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('description_en') border-red-300 @enderror"
                                                required placeholder="Full product description in English">{{ old('description_en') }}</textarea>
                                            @error('description_en')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="description_bn"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Description (Bengali)
                                            </label>
                                            <textarea name="description_bn" id="description_bn" rows="4"
                                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('description_bn') border-red-300 @enderror"
                                                placeholder="বাংলায় সম্পূর্ণ বিবরণ">{{ old('description_bn') }}</textarea>
                                            @error('description_bn')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Pricing</h2>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                        Price <span class="text-primary">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bengali">৳</span>
                                        </div>
                                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                                            class="pl-7 w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('price') border-red-300 @enderror"
                                            required min="0" max="999999.99" step="0.01" placeholder="0.00">
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-1">
                                        Compare Price
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bengali">৳</span>
                                        </div>
                                        <input type="number" name="compare_price" id="compare_price"
                                            value="{{ old('compare_price') }}"
                                            class="pl-7 w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('compare_price') border-red-300 @enderror"
                                            min="0" max="999999.99" step="0.01" placeholder="Original price">
                                    </div>
                                    @error('compare_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cost Price
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bengali">৳</span>
                                        </div>
                                        <input type="number" name="cost_price" id="cost_price"
                                            value="{{ old('cost_price') }}"
                                            class="pl-7 w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('cost_price') border-red-300 @enderror"
                                            min="0" max="999999.99" step="0.01" placeholder="Product cost">
                                    </div>
                                    @error('cost_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Inventory Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Inventory</h2>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <!-- Quantity & Status -->
                                <div class="space-y-6">
                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                            Quantity <span class="text-primary">*</span>
                                        </label>
                                        <input type="number" name="quantity" id="quantity"
                                            value="{{ old('quantity', 20) }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('quantity') border-red-300 @enderror"
                                            required min="0" max="99999">
                                        @error('quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-1">
                                            Stock Status <span class="text-primary">*</span>
                                        </label>
                                        <select name="stock_status" id="stock_status"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('stock_status') border-red-300 @enderror"
                                            required>
                                            <option value="in_stock"
                                                {{ old('stock_status', 'in_stock') == 'in_stock' ? 'selected' : '' }}>In
                                                Stock</option>
                                            <option value="out_of_stock"
                                                {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock
                                            </option>
                                            <option value="backorder"
                                                {{ old('stock_status') == 'backorder' ? 'selected' : '' }}>Backorder
                                            </option>
                                        </select>
                                        @error('stock_status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Alert & Settings -->
                                <div class="space-y-6">
                                    <div>
                                        <label for="alert_quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                            Alert Quantity
                                        </label>
                                        <input type="number" name="alert_quantity" id="alert_quantity"
                                            value="{{ old('alert_quantity', 5) }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('alert_quantity') border-red-300 @enderror"
                                            min="0" max="999999">
                                        @error('alert_quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <input type="hidden" name="track_quantity" value="0">
                                            <input type="checkbox" name="track_quantity" id="track_quantity"
                                                value="1" {{ old('track_quantity', true) ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <label for="track_quantity" class="ml-2 text-sm text-gray-700">
                                                Track Quantity
                                            </label>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="hidden" name="allow_backorder" value="0">
                                            <input type="checkbox" name="allow_backorder" id="allow_backorder"
                                                value="1" {{ old('allow_backorder') ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <label for="allow_backorder" class="ml-2 text-sm text-gray-700">
                                                Allow Backorders
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-lg font-semibold text-gray-900">Specifications</h2>
                                <button type="button" id="addSpecification"
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add
                                </button>
                            </div>

                            <div id="specifications-container" class="space-y-3">
                                @if (old('specifications'))
                                    @foreach (old('specifications') as $index => $spec)
                                        <div class="grid grid-cols-12 gap-3 items-start specification-row">
                                            <div class="col-span-5">
                                                <input type="text" name="specifications[{{ $index }}][key]"
                                                    value="{{ $spec['key'] ?? '' }}"
                                                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary"
                                                    placeholder="Key (e.g., Color)" maxlength="100">
                                            </div>
                                            <div class="col-span-5">
                                                <input type="text" name="specifications[{{ $index }}][value]"
                                                    value="{{ $spec['value'] ?? '' }}"
                                                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary"
                                                    placeholder="Value (e.g., Red)" maxlength="255">
                                            </div>
                                            <div class="col-span-2">
                                                <button type="button"
                                                    class="w-full inline-flex justify-center items-center px-3 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 remove-spec">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <p class="mt-3 text-sm text-gray-500">Add product specifications like dimensions, materials,
                                etc.</p>
                        </div>


                        <!-- SEO Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">SEO</h2>

                            <div class="space-y-4">
                                <!-- Meta Title -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="meta_title_en" class="block text-sm font-medium text-gray-700 mb-2">
                                            Meta Title (English)
                                        </label>
                                        <input type="text" name="meta_title_en" id="meta_title_en"
                                            value="{{ old('meta_title_en') }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('meta_title_en') border-red-300 @enderror"
                                            maxlength="70" placeholder="Product page title in English">
                                        @error('meta_title_en')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Maximum 70 characters</p>
                                    </div>

                                    <div>
                                        <label for="meta_title_bn" class="block text-sm font-medium text-gray-700 mb-2">
                                            Meta Title (Bengali)
                                        </label>
                                        <input type="text" name="meta_title_bn" id="meta_title_bn"
                                            value="{{ old('meta_title_bn') }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('meta_title_bn') border-red-300 @enderror"
                                            maxlength="70" placeholder="বাংলায় পৃষ্ঠার শিরোনাম">
                                        @error('meta_title_bn')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">সর্বোচ্চ ৭০ অক্ষর</p>
                                    </div>
                                </div>

                                <!-- Meta Description -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="meta_description_en"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Meta Description (English)
                                        </label>
                                        <textarea name="meta_description_en" id="meta_description_en" rows="2"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('meta_description_en') border-red-300 @enderror"
                                            maxlength="160" placeholder="Product page description in English">{{ old('meta_description_en') }}</textarea>
                                        @error('meta_description_en')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Maximum 160 characters</p>
                                    </div>

                                    <div>
                                        <label for="meta_description_bn"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Meta Description (Bengali)
                                        </label>
                                        <textarea name="meta_description_bn" id="meta_description_bn" rows="2"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('meta_description_bn') border-red-300 @enderror"
                                            maxlength="160" placeholder="বাংলায় পৃষ্ঠার বিবরণ">{{ old('meta_description_bn') }}</textarea>
                                        @error('meta_description_bn')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">সর্বোচ্চ ১৬০ অক্ষর</p>
                                    </div>
                                </div>

                                <!-- Meta Keywords -->
                                <div>
                                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                                        Meta Keywords
                                    </label>
                                    <input type="text" name="meta_keywords" id="meta_keywords"
                                        value="{{ old('meta_keywords') }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('meta_keywords') border-red-300 @enderror"
                                        maxlength="255" placeholder="Keyword1, Keyword2, Keyword3">
                                    @error('meta_keywords')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Comma separated keywords</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Media, Status, etc -->
                    <div class="space-y-6">
                        <!-- Images Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Images</h2>

                            <!-- Featured Images -->
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Featured Images <span class="text-primary">*</span>
                                    <span class="text-xs text-gray-500 font-normal">(2 images required)</span>
                                </label>

                                <div class="space-y-4">
                                    <!-- Upload Area -->
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors"
                                        id="featuredUploadArea">
                                        <input type="file" name="featured_images[]" id="featured_images"
                                            class="hidden" accept="image/*" multiple required>
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600">Drag & drop or click to upload</p>
                                        <p class="mt-1 text-xs text-gray-500">Max 2 images, 5MB each, min 300×300px</p>
                                        <button type="button"
                                            onclick="document.getElementById('featured_images').click()"
                                            class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                                            Select Images
                                        </button>
                                    </div>

                                    <!-- Preview -->
                                    <div class="grid grid-cols-2 gap-4" id="featuredPreview"></div>

                                    @error('featured_images')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @error('featured_images.*')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Gallery Images -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Gallery Images
                                    <span class="text-xs text-gray-500 font-normal">(Optional, max 5)</span>
                                </label>

                                <div class="space-y-4">
                                    <!-- Upload Area -->
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors"
                                        id="galleryUploadArea">
                                        <input type="file" name="gallery_images[]" id="gallery_images" class="hidden"
                                            accept="image/*" multiple>
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600">Drag & drop or click to upload</p>
                                        <p class="mt-1 text-xs text-gray-500">Max 5 images, 5MB each, min 300×300px</p>
                                        <button type="button" onclick="document.getElementById('gallery_images').click()"
                                            class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                                            Select Images
                                        </button>
                                    </div>

                                    <!-- Preview -->
                                    <div class="grid grid-cols-2 gap-4" id="galleryPreview"></div>

                                    @error('gallery_images')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @error('gallery_images.*')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status & Flags Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Status & Flags</h2>

                            <div class="space-y-6">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status <span class="text-primary">*</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('status') border-red-300 @enderror"
                                        required>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="active"
                                            {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>
                                            Archived</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-4">
                                    <h3 class="text-sm font-medium text-gray-700">Product Flags</h3>

                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <input type="hidden" name="is_featured" value="0">
                                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                                {{ old('is_featured') ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <label for="is_featured" class="ml-2 text-sm text-gray-700 flex items-center">
                                                <svg class="h-4 w-4 mr-1 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                Featured Product
                                            </label>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="hidden" name="is_bestsells" value="0">
                                            <input type="checkbox" name="is_bestsells" id="is_bestsells" value="1"
                                                {{ old('is_bestsells') ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <label for="is_bestsells"
                                                class="ml-2 text-sm text-gray-700 flex items-center">
                                                <svg class="h-4 w-4 mr-1 text-red-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                                                </svg>
                                                Best Selling
                                            </label>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="hidden" name="is_new" value="0">
                                            <input type="checkbox" name="is_new" id="is_new" value="1"
                                                {{ old('is_new', true) ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <label for="is_new" class="ml-2 text-sm text-gray-700 flex items-center">
                                                <svg class="h-4 w-4 mr-1 text-blue-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                New Arrival
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping & Dimensions Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Shipping & Dimensions</h2>

                            <div class="space-y-6">
                                <!-- Weight -->
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                        Weight
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="weight" id="weight" value="{{ old('weight') }}"
                                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('weight') border-red-300 @enderror"
                                            min="0" max="999.99" step="0.01" placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">kg</span>
                                        </div>
                                    </div>
                                    @error('weight')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Dimensions - 3 per row -->
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label for="length" class="block text-xs font-medium text-gray-700 mb-1">
                                            Length
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="length" id="length"
                                                value="{{ old('length') }}"
                                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('length') border-red-300 @enderror"
                                                min="0" max="999.99" step="0.01" placeholder="0.00">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                                <span class="text-xs text-gray-500">cm</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="width" class="block text-xs font-medium text-gray-700 mb-1">
                                            Width
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="width" id="width"
                                                value="{{ old('width') }}"
                                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('width') border-red-300 @enderror"
                                                min="0" max="999.99" step="0.01" placeholder="0.00">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                                <span class="text-xs text-gray-500">cm</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="height" class="block text-xs font-medium text-gray-700 mb-1">
                                            Height
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="height" id="height"
                                                value="{{ old('height') }}"
                                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('height') border-red-300 @enderror"
                                                min="0" max="999.99" step="0.01" placeholder="0.00">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                                <span class="text-xs text-gray-500">cm</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @error('length')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('width')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('height')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Warranty Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Warranty</h2>

                            <div class="grid grid-cols-3 gap-4">
                                <!-- Duration -->
                                <div>
                                    <label for="warranty_duration" class="block text-sm font-medium text-gray-700 mb-2">
                                        Duration
                                    </label>
                                    <input type="number" name="warranty_duration" id="warranty_duration"
                                        value="{{ old('warranty_duration') }}" min="0" max="99"
                                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('warranty_duration') border-red-300 @enderror">
                                    @error('warranty_duration')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Unit -->
                                <div>
                                    <label for="warranty_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                        Unit
                                    </label>
                                    <select name="warranty_unit" id="warranty_unit"
                                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('warranty_unit') border-red-300 @enderror">
                                        <option value="">Select</option>
                                        <option value="days" {{ old('warranty_unit') === 'days' ? 'selected' : '' }}>
                                            Days</option>
                                        <option value="months" {{ old('warranty_unit') === 'months' ? 'selected' : '' }}>
                                            Months</option>
                                        <option value="years" {{ old('warranty_unit') === 'years' ? 'selected' : '' }}>
                                            Years</option>
                                    </select>
                                    @error('warranty_unit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Warranty Type -->
                                <div>
                                    <label for="warranty_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Warranty Type
                                    </label>
                                    <select name="warranty_type" id="warranty_type"
                                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary @error('warranty_type') border-red-300 @enderror">
                                        <option value="">Select</option>
                                        <option value="replacement"
                                            {{ old('warranty_type') === 'replacement' ? 'selected' : '' }}>
                                            Replacement
                                        </option>
                                        <option value="service"
                                            {{ old('warranty_type') === 'service' ? 'selected' : '' }}>
                                            Service
                                        </option>
                                        <option value="parts" {{ old('warranty_type') === 'parts' ? 'selected' : '' }}>
                                            Parts
                                        </option>
                                    </select>
                                    @error('warranty_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.products.index') }}" data-loading data-loading-text="Canceling..."
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancel
                    </a>
                    <button type="submit" data-loading data-loading-text="Creating..."
                        class="px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        // Form validation and helpers
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image upload areas
            setupImageUpload();

            // Initialize specifications
            setupSpecifications();

            // Initialize SKU generator
            setupSkuGenerator();

            // Initialize drag and drop
            setupDragAndDrop();

            // Initialize character counters
            setupCharacterCounters();

            // Auto-generate slug from English name
            setupSlugGenerator();
        });

        // Image handling
        function setupImageUpload() {
            // Featured images
            const featuredInput = document.getElementById('featured_images');
            const featuredPreview = document.getElementById('featuredPreview');

            featuredInput.addEventListener('change', function() {
                handleImageUpload(this, featuredPreview, 2, true);
            });

            // Gallery images
            const galleryInput = document.getElementById('gallery_images');
            const galleryPreview = document.getElementById('galleryPreview');

            galleryInput.addEventListener('change', function() {
                handleImageUpload(this, galleryPreview, 5, false);
            });
        }

        function handleImageUpload(input, previewContainer, maxFiles, isFeatured) {
            const files = Array.from(input.files);
            previewContainer.innerHTML = '';

            // Limit to max files
            const validFiles = files.slice(0, maxFiles);

            validFiles.forEach((file, index) => {
                // File validation
                if (!file.type.startsWith('image/')) {
                    alert(`"${file.name}" is not a valid image file`);
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert(`"${file.name}" exceeds 5MB size limit`);
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                <button type="button" 
                        onclick="removeImage(this, ${index}, ${isFeatured})"
                        class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                    ×
                </button>
            `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });

            // For featured images: duplicate if only one
            if (isFeatured && validFiles.length === 1) {
                setTimeout(() => {
                    const firstImage = previewContainer.querySelector('div');
                    if (firstImage) {
                        const clonedImage = firstImage.cloneNode(true);
                        clonedImage.querySelector('button').setAttribute('onclick', `removeImage(this, 1, true)`);
                        previewContainer.appendChild(clonedImage);
                    }
                }, 100);
            }
        }

        function removeImage(button, index, isFeatured) {
            const input = isFeatured ? document.getElementById('featured_images') : document.getElementById(
                'gallery_images');
            const dt = new DataTransfer();
            const files = Array.from(input.files);

            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;

            // Trigger change event to update preview
            const event = new Event('change');
            input.dispatchEvent(event);
        }

        // Drag and drop
        function setupDragAndDrop() {
            const areas = [{
                    id: 'featuredUploadArea',
                    inputId: 'featured_images'
                },
                {
                    id: 'galleryUploadArea',
                    inputId: 'gallery_images'
                }
            ];

            areas.forEach(area => {
                const dropArea = document.getElementById(area.id);
                const input = document.getElementById(area.inputId);
                const isFeatured = area.inputId === 'featured_images';

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, () => {
                        dropArea.classList.add('border-primary', 'bg-primary/5');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, () => {
                        dropArea.classList.remove('border-primary', 'bg-primary/5');
                    }, false);
                });

                dropArea.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    input.files = files;

                    const event = new Event('change');
                    input.dispatchEvent(event);
                }
            });
        }

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Specifications
        function setupSpecifications() {
            const addButton = document.getElementById('addSpecification');
            const container = document.getElementById('specifications-container');

            addButton.addEventListener('click', function() {
                const index = container.children.length;
                const row = document.createElement('div');
                row.className = 'grid grid-cols-12 gap-3 items-start specification-row';
                row.innerHTML = `
            <div class="col-span-5">
                <input type="text" 
                       name="specifications[${index}][key]" 
                       class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary"
                       placeholder="Key"
                       maxlength="100">
            </div>
            <div class="col-span-5">
                <input type="text" 
                       name="specifications[${index}][value]" 
                       class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary"
                       placeholder="Value"
                       maxlength="255">
            </div>
            <div class="col-span-2">
                <button type="button" 
                        onclick="this.closest('.specification-row').remove()"
                        class="w-full inline-flex justify-center items-center px-3 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50">
                    Remove
                </button>
            </div>
        `;
                container.appendChild(row);
            });
        }

        // SKU Generator
        function setupSkuGenerator() {
            document.getElementById('generateSku').addEventListener('click', function() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                let sku = 'SKU-';

                // Generate 3 random characters
                for (let i = 0; i < 3; i++) {
                    sku += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                // Add date
                const date = new Date();
                const dateStr = date.getFullYear().toString().slice(2) +
                    (date.getMonth() + 1).toString().padStart(2, '0') +
                    date.getDate().toString().padStart(2, '0');
                sku += '-' + dateStr;

                // Add random number
                sku += '-' + Math.floor(100 + Math.random() * 900);

                document.getElementById('sku').value = sku;
            });
        }

        // Slug Generator
        function setupSlugGenerator() {
            const nameEnInput = document.getElementById('name_en');
            const slugInput = document.getElementById('slug');

            nameEnInput.addEventListener('input', function() {
                if (!slugInput.dataset.manual) {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/--+/g, '-')
                        .trim();
                    slugInput.value = slug;
                }
            });

            // Mark slug as manually modified
            slugInput.addEventListener('input', function() {
                this.dataset.manual = 'true';
            });
        }

        // Form validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            // Basic validation
            const requiredFields = ['name_en', 'category_id', 'description_en', 'price', 'quantity', 'status',
                'stock_status'
            ];
            let isValid = true;

            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-300');
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains(
                            'text-red-600')) {
                        const error = document.createElement('p');
                        error.className = 'mt-1 text-sm text-red-600';
                        error.textContent = 'This field is required';
                        field.parentNode.appendChild(error);
                    }
                }
            });

            // Check featured images
            const featuredInput = document.getElementById('featured_images');
            if (featuredInput.files.length === 0) {
                isValid = false;
                alert('Please upload at least one featured image');
            }

            // Check compare price
            const price = parseFloat(document.getElementById('price').value) || 0;
            const comparePrice = parseFloat(document.getElementById('compare_price').value) || 0;

            if (comparePrice > 0 && comparePrice <= price) {
                isValid = false;
                alert('Compare price must be greater than regular price');
                document.getElementById('compare_price').focus();
            }

            // Validate gallery images count
            const galleryInput = document.getElementById('gallery_images');
            if (galleryInput.files.length > 5) {
                isValid = false;
                alert('Maximum 5 gallery images allowed');
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Real-time validation
        function validateComparePrice() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const comparePrice = parseFloat(document.getElementById('compare_price').value) || 0;

            if (comparePrice > 0 && comparePrice <= price) {
                document.getElementById('compare_price').classList.add('border-red-300');
                const error = document.getElementById('comparePriceError') || document.createElement('p');
                error.id = 'comparePriceError';
                error.className = 'mt-1 text-sm text-red-600';
                error.textContent = 'Compare price must be greater than regular price';

                const parent = document.getElementById('compare_price').parentNode;
                if (!document.getElementById('comparePriceError')) {
                    parent.appendChild(error);
                }
            } else {
                document.getElementById('compare_price').classList.remove('border-red-300');
                const error = document.getElementById('comparePriceError');
                if (error) error.remove();
            }
        }

        // Add event listeners for real-time validation
        document.getElementById('price').addEventListener('input', validateComparePrice);
        document.getElementById('compare_price').addEventListener('input', validateComparePrice);

        // Character counters
        function setupCharacterCounters() {
            const fields = [{
                    id: 'short_description_en',
                    max: 500
                },
                {
                    id: 'short_description_bn',
                    max: 500
                },
                {
                    id: 'meta_title_en',
                    max: 70
                },
                {
                    id: 'meta_title_bn',
                    max: 70
                },
                {
                    id: 'meta_description_en',
                    max: 160
                },
                {
                    id: 'meta_description_bn',
                    max: 160
                },
                {
                    id: 'meta_keywords',
                    max: 255
                }
            ];

            fields.forEach(field => {
                const element = document.getElementById(field.id);
                if (element) {
                    const counter = document.createElement('p');
                    counter.className = 'mt-1 text-xs text-gray-500 text-right';
                    counter.id = `${field.id}_counter`;

                    element.parentNode.appendChild(counter);

                    element.addEventListener('input', function() {
                        const count = this.value.length;
                        counter.textContent = `${count}/${field.max} characters`;
                        counter.className =
                            `mt-1 text-xs ${count > field.max ? 'text-red-500' : 'text-gray-500'} text-right`;
                    });

                    // Trigger initial count
                    element.dispatchEvent(new Event('input'));
                }
            });
        }
    </script>
@endpush
