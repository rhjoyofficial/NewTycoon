@extends('admin.layouts.app')

@section('title', 'Edit Ad Banner')
@section('page-title', 'Edit Ad Banner')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.content.ad-banners.index') }}" class="text-primary hover:text-primary/80">Ad Banners</a>
    </li>
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Edit</span>
    </li>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.content.ad-banners.update', $adBanner) }}" data-form method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow p-6 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $adBanner->title) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Images</label>
                    <div class="flex flex-wrap gap-4 mb-4">
                        @foreach ($adBanner->images as $image)
                            <div class="relative">
                                <img src="{{ Storage::url($image) }}" class="h-20 w-20 object-cover rounded border">
                            </div>
                        @endforeach
                    </div>

                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Replace Images (optional, max
                        10, each 2MB)</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep current images. Uploading new images will
                        replace all existing ones.</p>
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link -->
                <div>
                    <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Link (URL)</label>
                    <input type="text" name="link" id="link" value="{{ old('link', $adBanner->link) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    @error('link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order & Active -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $adBanner->order) }}"
                            min="0"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center mt-6">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $adBanner->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.content.ad-banners.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                    <button type="submit" data-loading data-loading-text="Updating..."
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">Update
                        Banner</button>
                </div>
            </div>
        </form>
    </div>
@endsection
