@extends('admin.layouts.app')

@section('title_en', 'Create Section')
@section('page-title_en', 'Create Section')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.content.sections.index') }}" class="text-primary hover:text-primary/80">Sections</a>
    </li>
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Create</span>
    </li>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.content.sections.store') }}" data-form method="POST">
            @csrf

            <div class="bg-white rounded-lg shadow p-6 space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Internal Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="Enter Internal Name in English">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">Display Title
                            (English) <span class="text-primary">*</span></label>
                        <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="Enter Display Title in English">
                        @error('title_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title_bn" class="block text-sm font-medium text-gray-700 mb-1">Display Title
                            (Bengali)</label>
                        <input type="text" name="title_bn" id="title_bn" value="{{ old('title_bn') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="বাংলায় টাইটেল লিখুন">
                        @error('title_bn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Section Type  <span class="text-primary">*</span></label>
                        <select name="type" id="type"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                            <option value="product_slider" {{ old('type') == 'product_slider' ? 'selected' : '' }}>Product
                                Slider</option>
                            <option value="banner" {{ old('type') == 'banner' ? 'selected' : '' }}>Banner Section</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                        <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Banner Selection -->
                    <div>
                        <label for="ad_banner_id" class="block text-sm font-medium text-gray-700 mb-1">Associated
                            Banner</label>
                        <select name="ad_banner_id" id="ad_banner_id"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                            <option value="">None (No Banner)</option>
                            @foreach ($banners as $banner)
                                <option value="{{ $banner->id }}"
                                    {{ old('ad_banner_id') == $banner->id ? 'selected' : '' }}>
                                    {{ $banner->title_en ?? 'Banner #' . $banner->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('ad_banner_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Settings JSON -->
                <div>
                    <label for="settings" class="block text-sm font-medium text-gray-700 mb-1">Settings (JSON)</label>
                    <textarea name="settings" id="settings" rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary font-mono text-sm">{{ old('settings') }}</textarea>
                    @error('settings')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Example: {"product_type":"new_arrivals", "slidesPerView":4, "autoPlay":true}
                    </p>
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.content.sections.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                    <button type="submit" data-loading data-loading-text="Creating..."
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">Create
                        Section</button>
                </div>
            </div>
        </form>
    </div>
@endsection
