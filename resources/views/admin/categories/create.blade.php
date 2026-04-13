@extends('admin.layouts.app')

@section('title', 'Create Category')
@section('page-title', 'Create New Category')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700">Categories</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Create</span>
    </li>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto">
        <form action="{{ route('admin.categories.store') }}" method="POST" data-form enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Category Information</h2>
                            <p class="text-sm text-gray-600 mt-1">Fill in the details to create a new category</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.categories.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" data-loading data-loading-text="Creating..."
                                class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                Create Category
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>

                        <!-- English & Bengali Names -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category Name (English) *
                                </label>
                                <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Enter category name in English">
                                @error('name_en')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category Name (Bengali)
                                </label>
                                <input type="text" id="name_bn" name="name_bn" value="{{ old('name_bn') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="বাংলায় ক্যাটাগরির নাম লিখুন">
                                @error('name_bn')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Parent Category & Order -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Parent Category
                                </label>
                                <select id="parent_id" name="parent_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="">Select Parent Category</option>
                                    @foreach ($parentCategories as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->full_name  }}
                                            {{-- @if ($parent->name_bn)
                                                ({{ $parent->name_bn }})
                                            @endif --}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                                        Display Order
                                    </label>
                                    <input type="number" id="order" name="order" value="{{ old('order', 0) }}"
                                        min="0"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0">
                                    @error('order')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nav_order" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nav Order
                                    </label>
                                    <input type="number" id="nav_order" name="nav_order" value="{{ old('nav_order', 0) }}"
                                        min="0"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0">
                                    @error('nav_order')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- English & Bengali Descriptions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="description_en" class="block text-sm font-medium text-gray-700 mb-1">
                                    Description (English)
                                </label>
                                <textarea id="description_en" name="description_en" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Enter category description in English">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                    Description (Bengali)
                                </label>
                                <textarea id="description_bn" name="description_bn" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="বাংলায় ক্যাটাগরির বিবরণ লিখুন">{{ old('description_bn') }}</textarea>
                                @error('description_bn')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status & Features -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                </label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center mr-4">
                                        <input type="radio" name="is_active" value="1"
                                            {{ old('is_active', true) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Active</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="is_active" value="0"
                                            {{ old('is_active') === '0' ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Inactive</span>
                                    </label>
                                </div>
                                @error('is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <!-- fallback -->
                                    <input type="hidden" name="is_featured" value="0">

                                    <input type="checkbox" name="is_featured" value="1"
                                        {{ old('is_featured') ? 'checked' : '' }}
                                        class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">

                                    <span class="ml-2 text-sm text-gray-700">Featured Category</span>
                                </label>

                                <label class="flex items-center">
                                    <!-- fallback -->
                                    <input type="hidden" name="show_in_nav" value="0">

                                    <input type="checkbox" name="show_in_nav" value="1"
                                        {{ old('show_in_nav') ? 'checked' : '' }}
                                        class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">

                                    <span class="ml-2 text-sm text-gray-700">Show in Navigation</span>
                                </label>
                            </div>


                            <!-- Slug Field -->
                            {{-- <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                                    Custom Slug
                                </label>
                                <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="custom-slug (optional)">
                                <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from English name</p>
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Category Image</h3>

                        <div class="flex items-start space-x-6">
                            <!-- Image Preview -->
                            <div class="w-40">
                                <div id="imagePreview"
                                    class="h-40 w-40 border-2 border-dashed border-gray-300 rounded-2xl flex items-center justify-center bg-gray-50 overflow-hidden hidden">
                                    <img id="previewImage" class="h-full w-full object-cover">
                                </div>
                                <div id="noImage"
                                    class="h-40 w-40 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center bg-gray-50">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-xs text-gray-500">No image</p>
                                </div>
                            </div>

                            <!-- Upload Controls -->
                            <div class="flex-1">
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                        Upload Image
                                    </label>
                                    <input type="file" id="image" name="image" accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"
                                        onchange="previewFile(event)">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Recommended size: 400x400px. Supports: JPG, PNG, JPEG, WEBP (Max: 2MB)
                                    </p>
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">SEO Settings</h3>
                        <p class="text-sm text-gray-600">Customize how this category appears in search engines</p>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Meta Title -->
                                <div>
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">
                                        Meta Title
                                    </label>
                                    <input type="text" id="meta_title" name="meta_title"
                                        value="{{ old('meta_title') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Enter meta title">
                                    <p class="mt-1 text-xs text-gray-500">50-60 characters</p>
                                    @error('meta_title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Meta Description -->
                                <div class="md:col-span-2">
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">
                                        Meta Description
                                    </label>
                                    <textarea id="meta_description" name="meta_description" rows="2"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Enter meta description for SEO">{{ old('meta_description') }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">150-160 characters recommended</p>
                                    @error('meta_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">
                                    Meta Keywords
                                </label>
                                <input type="text" id="meta_keywords" name="meta_keywords"
                                    value="{{ old('meta_keywords') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="keyword1, keyword2, keyword3">
                                <p class="mt-1 text-xs text-gray-500">Separate keywords with commas</p>
                                @error('meta_keywords')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" data-loading data-loading-text="Creating..."
                            class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Create Category
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function previewFile(event) {
            const preview = document.getElementById('previewImage');
            const previewDiv = document.getElementById('imagePreview');
            const noImageDiv = document.getElementById('noImage');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                    noImageDiv.classList.add('hidden');
                }

                reader.readAsDataURL(file);
            } else {
                previewDiv.classList.add('hidden');
                noImageDiv.classList.remove('hidden');
            }
        }

        // Auto-generate slug from English name
        document.getElementById('name_en').addEventListener('input', function() {
            const slugField = document.getElementById('slug');
            if (!slugField.value) {
                const slug = this.value.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-');
                slugField.value = slug;
            }
        });

        // Mark slug as manually modified
        document.getElementById('slug').addEventListener('input', function() {
            this.dataset.manual = 'true';
        });
    </script>
@endpush
