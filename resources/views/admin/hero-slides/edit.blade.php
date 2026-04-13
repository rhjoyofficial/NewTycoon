@extends('admin.layouts.app')

@section('title', 'Edit Slide')
@section('page-title', 'Edit Hero Slide')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.hero-slides.index') }}" class="text-gray-500 hover:text-gray-700">Hero Slides</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Edit</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <form action="{{ route('admin.hero-slides.update', $heroSlide) }}" method="POST" enctype="multipart/form-data"
            id="slideForm" data-form>
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column: Form -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Form Header -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Slide Information</h2>
                                    <p class="text-sm text-gray-600 mt-1">Update hero slide details</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.hero-slides.index') }}"
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </a>
                                    <button type="submit" data-loading data-loading-text="Updating..."
                                        class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                        Update Slide
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Content -->
                        <div class="p-6 space-y-6">
                            <!-- Background & Type -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Background & Type</h3>

                                <div class="space-y-4">
                                    <!-- Type -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Slide Type *
                                        </label>
                                        <div class="mt-2 space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="type" value="image"
                                                    {{ old('type', $heroSlide->type) === 'image' ? 'checked' : '' }}
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Image</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="type" value="video"
                                                    {{ old('type', $heroSlide->type) === 'video' ? 'checked' : '' }}
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Video</span>
                                            </label>
                                        </div>
                                        @error('type')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Background File -->
                                    <div>
                                        <label for="background" class="block text-sm font-medium text-gray-700 mb-1">
                                            Background File
                                        </label>
                                        <input type="file" name="background" id="background" accept="image/*,video/*"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                        <p class="mt-1 text-xs text-gray-500">
                                            Leave empty to keep current file. Images: JPG, PNG, WEBP (Max: 10MB) | Videos:
                                            MP4, MOV, AVI (Max: 10MB)
                                        </p>
                                        @error('background')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror

                                        @if ($heroSlide->background)
                                            <div class="mt-2">
                                                <p class="text-xs text-gray-500 mb-2">Current:
                                                    {{ basename($heroSlide->background) }}</p>
                                                <div class="h-24 w-32 rounded overflow-hidden border">
                                                    @if ($heroSlide->type === 'image')
                                                        <img src="{{ asset('storage/' . $heroSlide->background) }}"
                                                            class="h-full w-full object-cover" alt="Current slide">
                                                    @else
                                                        <div
                                                            class="h-full w-full bg-gray-800 flex items-center justify-center">
                                                            <svg class="h-8 w-8 text-white" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Content Settings -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Content</h3>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="has_content" value="1" id="hasContent"
                                            {{ old('has_content', $heroSlide->has_content) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Enable Content</span>
                                    </label>
                                </div>

                                <div id="contentFields"
                                    class="space-y-6 {{ old('has_content', $heroSlide->has_content) ? '' : 'hidden' }}">
                                    <!-- Content Position -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Content Position *
                                        </label>
                                        <div class="mt-2 space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="content_position" value="left"
                                                    {{ old('content_position', $heroSlide->content_position) === 'left' ? 'checked' : '' }}
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Left</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="content_position" value="center"
                                                    {{ old('content_position', $heroSlide->content_position) === 'center' ? 'checked' : '' }}
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Center</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="content_position" value="right"
                                                    {{ old('content_position', $heroSlide->content_position) === 'right' ? 'checked' : '' }}
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">Right</span>
                                            </label>
                                        </div>
                                        @error('content_position')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Badge -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="badge_en" class="block text-sm font-medium text-gray-700 mb-1">
                                                Badge (English)
                                            </label>
                                            <input type="text" name="badge_en" id="badge_en"
                                                value="{{ old('badge_en', $heroSlide->badge_en) }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="e.g., New, Sale, Limited">
                                            @error('badge_en')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="badge_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                                Badge (বাংলা)
                                            </label>
                                            <input type="text" name="badge_bn" id="badge_bn"
                                                value="{{ old('badge_bn', $heroSlide->badge_bn) }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="যেমনঃ নতুন, বিক্রি, সীমিত">
                                            @error('badge_bn')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Title -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">
                                                Title (English)
                                            </label>
                                            <textarea name="title_en" id="title_en" rows="2"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="Enter main title">{{ old('title_en', $heroSlide->title_en) }}</textarea>
                                            @error('title_en')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="title_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                                Title (বাংলা)
                                            </label>
                                            <textarea name="title_bn" id="title_bn" rows="2"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="মূল শিরোনাম লিখুন">{{ old('title_bn', $heroSlide->title_bn) }}</textarea>
                                            @error('title_bn')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Subtitle -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="subtitle_en" class="block text-sm font-medium text-gray-700 mb-1">
                                                Subtitle (English)
                                            </label>
                                            <textarea name="subtitle_en" id="subtitle_en" rows="3"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="Enter supporting text">{{ old('subtitle_en', $heroSlide->subtitle_en) }}</textarea>
                                            @error('subtitle_en')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="subtitle_bn" class="block text-sm font-medium text-gray-700 mb-1">
                                                Subtitle (বাংলা)
                                            </label>
                                            <textarea name="subtitle_bn" id="subtitle_bn" rows="3"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                                placeholder="সহায়ক পাঠ্য লিখুন">{{ old('subtitle_bn', $heroSlide->subtitle_bn) }}</textarea>
                                            @error('subtitle_bn')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Settings -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Call to Action</h3>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="has_cta" value="1" id="hasCta"
                                            {{ old('has_cta', $heroSlide->has_cta) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Enable CTA Buttons</span>
                                    </label>
                                </div>

                                <div id="ctaFields"
                                    class="space-y-4 {{ old('has_cta', $heroSlide->has_cta) ? '' : 'hidden' }}">
                                    <div id="ctaButtonsContainer" class="space-y-4">
                                        @php
                                            $ctaButtons = old('cta_buttons', $heroSlide->cta_buttons ?? []);
                                            if (empty($ctaButtons)) {
                                                $ctaButtons = [
                                                    [
                                                        'label_en' => '',
                                                        'label_bn' => '',
                                                        'url' => '',
                                                        'style' => 'primary',
                                                    ],
                                                ];
                                            }
                                        @endphp

                                        @foreach ($ctaButtons as $index => $button)
                                            <div class="p-4 border border-gray-200 rounded-xl space-y-4">
                                                <div class="flex justify-between items-center">
                                                    <h4 class="text-sm font-medium text-gray-900">Button
                                                        {{ $index + 1 }}</h4>
                                                    @if ($index > 0)
                                                        <button type="button" onclick="removeCtaButton(this)"
                                                            class="text-red-500 hover:text-red-700">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                                            Label (English) *
                                                        </label>
                                                        <input type="text"
                                                            name="cta_buttons[{{ $index }}][label_en]"
                                                            value="{{ $button['label_en'] ?? '' }}"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                            placeholder="e.g., Shop Now">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                                            Label (বাংলা)
                                                        </label>
                                                        <input type="text"
                                                            name="cta_buttons[{{ $index }}][label_bn]"
                                                            value="{{ $button['label_bn'] ?? '' }}"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                            placeholder="যেমনঃ কিনুন">
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                                            URL *
                                                        </label>
                                                        <input type="text"
                                                            name="cta_buttons[{{ $index }}][url]"
                                                            value="{{ $button['url'] ?? '' }}"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                            placeholder="e.g., /shop or https://example.com">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                                            Style *
                                                        </label>
                                                        <select name="cta_buttons[{{ $index }}][style]"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                                            <option value="primary"
                                                                {{ ($button['style'] ?? 'primary') === 'primary' ? 'selected' : '' }}>
                                                                Primary</option>
                                                            <option value="secondary"
                                                                {{ ($button['style'] ?? 'primary') === 'secondary' ? 'selected' : '' }}>
                                                                Secondary</option>
                                                            <option value="outline"
                                                                {{ ($button['style'] ?? 'primary') === 'outline' ? 'selected' : '' }}>
                                                                Outline</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" onclick="addCtaButton()"
                                        class="text-primary hover:text-primary/80 flex items-center text-sm font-medium">
                                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add Another Button
                                    </button>
                                </div>
                            </div>

                            <!-- Settings -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Settings</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Status
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1"
                                                {{ old('is_active', $heroSlide->is_active) ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                            <span class="ml-2 text-sm text-gray-700">Active</span>
                                        </label>
                                        @error('is_active')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Sort Order -->
                                    <div>
                                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">
                                            Sort Order
                                        </label>
                                        <input type="number" name="sort_order" id="sort_order"
                                            value="{{ old('sort_order', $heroSlide->sort_order) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="0">
                                        @error('sort_order')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('admin.hero-slides.index') }}"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                    Cancel
                                </a>
                                <button type="submit" data-loading data-loading-text="Updating..."
                                    class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all flex items-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Slide
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Preview -->
                <div class="lg:sticky lg:top-6 h-fit">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Live Preview</h3>
                            <p class="text-sm text-gray-600 mt-1">Preview how your slide will look</p>
                        </div>

                        <div class="p-6">
                            <!-- Hero Preview Container -->
                            <section class="relative w-full overflow-hidden" id="heroPreview">
                                <div
                                    class="w-full aspect-[16/9] max-h-[600px] overflow-hidden bg-gray-900/50 rounded-lg border border-gray-300">
                                    <div class="relative w-full h-full" id="previewSlide">
                                        <!-- Current/Uploaded Media -->
                                        @if ($heroSlide->background)
                                            @if ($heroSlide->type === 'image')
                                                <img src="{{ asset('storage/' . $heroSlide->background) }}"
                                                    class="absolute inset-0 w-full h-full object-cover" id="currentMedia"
                                                    alt="Preview">
                                            @else
                                                <video class="absolute inset-0 w-full h-full object-cover" autoplay muted
                                                    loop playsinline id="currentMedia">
                                                    <source src="{{ asset('storage/' . $heroSlide->background) }}"
                                                        type="video/mp4">
                                                </video>
                                            @endif
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                                <div class="text-center">
                                                    <svg class="h-12 w-12 mx-auto mb-3" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <p class="text-sm">Upload a file to preview</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>

                            <!-- Preview Information -->
                            <div class="mt-6 space-y-4">
                                <h4 class="text-sm font-medium text-gray-900">Preview Settings</h4>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Content Position:</span>
                                            <span id="previewPosition"
                                                class="text-sm font-medium text-gray-900">{{ ucfirst($heroSlide->content_position) }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Has Content:</span>
                                            <span id="previewHasContent"
                                                class="text-sm font-medium text-gray-900">{{ $heroSlide->has_content ? 'Yes' : 'No' }}</span>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Has CTA:</span>
                                            <span id="previewHasCta"
                                                class="text-sm font-medium text-gray-900">{{ $heroSlide->has_cta ? 'Yes' : 'No' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Slide Type:</span>
                                            <span id="previewType"
                                                class="text-sm font-medium text-gray-900">{{ ucfirst($heroSlide->type) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview Controls -->
                                <div class="flex items-center gap-2 pt-4 border-t border-gray-200">
                                    <span class="text-sm text-gray-600">Preview Scale:</span>
                                    <div class="flex-1">
                                        <input type="range" id="previewScale" min="50" max="100"
                                            value="100"
                                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                    </div>
                                    <span id="scaleValue"
                                        class="text-sm font-medium text-gray-900 w-12 text-right">100%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle content fields
        const hasContentCheckbox = document.getElementById('hasContent');
        const contentFields = document.getElementById('contentFields');

        hasContentCheckbox.addEventListener('change', function() {
            contentFields.classList.toggle('hidden', !this.checked);
            updatePreview();
        });

        // Toggle CTA fields
        const hasCtaCheckbox = document.getElementById('hasCta');
        const ctaFields = document.getElementById('ctaFields');

        hasCtaCheckbox.addEventListener('change', function() {
            ctaFields.classList.toggle('hidden', !this.checked);
            updatePreview();
        });

        // Handle file upload preview
        const backgroundInput = document.getElementById('background');
        backgroundInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const previewSlide = document.getElementById('previewSlide');
            const placeholder = previewSlide.querySelector('.absolute.inset-0.flex');

            if (placeholder) {
                placeholder.remove();
            }

            // Remove existing background if any
            const existingBg = previewSlide.querySelector('video, img');
            if (existingBg) {
                existingBg.remove();
            }

            const url = URL.createObjectURL(file);
            const type = document.querySelector('input[name="type"]:checked').value;

            let mediaElement;
            if (type === 'video') {
                mediaElement = document.createElement('video');
                mediaElement.className = 'absolute inset-0 w-full h-full object-cover';
                mediaElement.autoplay = true;
                mediaElement.muted = true;
                mediaElement.loop = true;
                mediaElement.playsInline = true;
                mediaElement.src = url;
                mediaElement.id = 'currentMedia';
            } else {
                mediaElement = document.createElement('img');
                mediaElement.className = 'absolute inset-0 w-full h-full object-cover object-center';
                mediaElement.src = url;
                mediaElement.id = 'currentMedia';
            }

            previewSlide.insertBefore(mediaElement, previewSlide.firstChild);

            // Update preview type display
            document.getElementById('previewType').textContent = type.charAt(0).toUpperCase() + type.slice(1);

            updatePreview();
        });

        // Update preview scale
        const scaleSlider = document.getElementById('previewScale');
        const scaleValue = document.getElementById('scaleValue');

        scaleSlider.addEventListener('input', function() {
            const value = this.value + '%';
            scaleValue.textContent = value;
            document.getElementById('heroPreview').style.transform = `scale(${this.value / 100})`;
            document.getElementById('heroPreview').style.transformOrigin = 'top center';
        });

        // Update preview based on form values
        function updatePreview() {
            const hasContent = hasContentCheckbox.checked;
            const hasCta = hasCtaCheckbox.checked;
            const contentPosition = document.querySelector('input[name="content_position"]:checked')?.value || 'left';

            // Update preview indicators
            document.getElementById('previewHasContent').textContent = hasContent ? 'Yes' : 'No';
            document.getElementById('previewHasCta').textContent = hasCta ? 'Yes' : 'No';
            document.getElementById('previewPosition').textContent = contentPosition.charAt(0).toUpperCase() +
                contentPosition.slice(1);

            const previewSlide = document.getElementById('previewSlide');

            // Remove existing content if any
            const existingContent = previewSlide.querySelector('#previewContentContainer');
            if (existingContent) {
                existingContent.remove();
            }

            // Remove existing overlay
            const existingOverlay = previewSlide.querySelector('.bg-black\\/40');
            if (existingOverlay) {
                existingOverlay.remove();
            }

            if (!hasContent) return;

            // Add overlay if content is enabled
            const overlay = document.createElement('div');
            overlay.className = 'absolute inset-0 bg-black/40';
            previewSlide.appendChild(overlay);

            // Create content container
            const contentContainer = document.createElement('div');
            contentContainer.id = 'previewContentContainer';
            contentContainer.className = 'absolute inset-0 flex items-center justify-center';
            previewSlide.appendChild(contentContainer);

            // Create content wrapper
            const contentWrapper = document.createElement('div');
            contentWrapper.className = 'container mx-auto px-6 md:px-12 lg:px-16 w-full';
            contentContainer.appendChild(contentWrapper);

            // Create content
            const content = document.createElement('div');
            let positionClass = '';
            if (contentPosition === 'right') {
                positionClass = 'ml-auto text-right';
            } else if (contentPosition === 'center') {
                positionClass = 'mx-auto text-center';
            } else {
                positionClass = 'text-left';
            }
            content.className = `max-w-3xl transition-all duration-700 ${positionClass}`;
            contentWrapper.appendChild(content);

            // Add badge if exists
            const badge = document.getElementById('badge_en')?.value || '';
            if (badge) {
                const badgeEl = document.createElement('div');
                badgeEl.className = 'inline-flex items-center px-3 py-1 bg-white/10 rounded-full mb-4';
                badgeEl.innerHTML = `<span class="text-xs uppercase font-bold text-white">${badge}</span>`;
                content.appendChild(badgeEl);
            }

            // Add title
            const title = document.getElementById('title_en')?.value || 'Your Title Here';
            if (title) {
                const titleEl = document.createElement('h1');
                titleEl.className = 'text-4xl font-bold text-white mb-4';
                titleEl.textContent = title;
                content.appendChild(titleEl);
            }

            // Add subtitle
            const subtitle = document.getElementById('subtitle_en')?.value || '';
            if (subtitle) {
                const subtitleEl = document.createElement('p');
                subtitleEl.className = 'text-lg text-white/80 mb-8';
                subtitleEl.textContent = subtitle;
                content.appendChild(subtitleEl);
            }

            // Add CTA buttons if enabled
            if (hasCta) {
                const ctaContainer = document.createElement('div');
                let ctaAlign = '';
                if (contentPosition === 'center') {
                    ctaAlign = 'justify-center';
                } else if (contentPosition === 'right') {
                    ctaAlign = 'justify-end';
                } else {
                    ctaAlign = 'justify-start';
                }
                ctaContainer.className = `flex gap-4 ${ctaAlign}`;

                // Get CTA buttons
                const buttonContainers = document.querySelectorAll('#ctaButtonsContainer > div');
                buttonContainers.forEach((container, index) => {
                    const labelInput = container.querySelector(`[name="cta_buttons[${index}][label_en]"]`);
                    const urlInput = container.querySelector(`[name="cta_buttons[${index}][url]"]`);
                    const styleInput = container.querySelector(`[name="cta_buttons[${index}][style]"]`);

                    if (labelInput && labelInput.value) {
                        const label = labelInput.value || `Button ${index + 1}`;
                        const url = urlInput?.value || '#';
                        const style = styleInput?.value || 'primary';

                        const button = document.createElement('a');
                        button.href = url;
                        button.className = `px-6 py-3 rounded-lg font-bold transition-colors ${
                            style === 'primary' 
                                ? 'bg-white text-black hover:bg-white/90' 
                                : 'border border-white text-white hover:bg-white/10'
                        }`;
                        button.textContent = label;
                        ctaContainer.appendChild(button);
                    }
                });

                content.appendChild(ctaContainer);
            }
        }

        // Listen to form changes for live preview
        document.querySelectorAll('#slideForm input, #slideForm textarea, #slideForm select').forEach(element => {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        });

        // Listen to radio button changes
        document.querySelectorAll('input[name="content_position"], input[name="type"]').forEach(radio => {
            radio.addEventListener('change', updatePreview);
        });

        // CTA button management
        let ctaButtonIndex = {{ count($ctaButtons ?? []) }};

        function addCtaButton() {
            if (ctaButtonIndex >= 3) {
                alert('Maximum 3 buttons allowed');
                return;
            }

            const container = document.getElementById('ctaButtonsContainer');
            const newButton = document.createElement('div');
            newButton.className = 'p-4 border border-gray-200 rounded-xl space-y-4';
            newButton.innerHTML = `
                <div class="flex justify-between items-center">
                    <h4 class="text-sm font-medium text-gray-900">Button ${ctaButtonIndex + 1}</h4>
                    <button type="button" onclick="removeCtaButton(this)" class="text-red-500 hover:text-red-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Label (English) *
                        </label>
                        <input type="text" name="cta_buttons[${ctaButtonIndex}][label_en]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                               placeholder="e.g., Shop Now">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Label (বাংলা)
                        </label>
                        <input type="text" name="cta_buttons[${ctaButtonIndex}][label_bn]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                               placeholder="যেমনঃ কিনুন">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            URL *
                        </label>
                        <input type="text" name="cta_buttons[${ctaButtonIndex}][url]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                               placeholder="e.g., /shop or https://example.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Style *
                        </label>
                        <select name="cta_buttons[${ctaButtonIndex}][style]"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="primary">Primary</option>
                            <option value="secondary">Secondary</option>
                            <option value="outline">Outline</option>
                        </select>
                    </div>
                </div>
            `;

            container.appendChild(newButton);
            ctaButtonIndex++;

            // Add event listeners to new inputs
            const newInputs = newButton.querySelectorAll('input, select');
            newInputs.forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            updatePreview();
        }

        function removeCtaButton(button) {
            const containers = document.querySelectorAll('#ctaButtonsContainer > div');
            if (containers.length <= 1) return;

            button.closest('.p-4').remove();

            // Reindex remaining buttons
            const buttons = document.querySelectorAll('#ctaButtonsContainer > div');
            buttons.forEach((div, index) => {
                div.querySelector('h4').textContent = `Button ${index + 1}`;

                // Update input names
                const inputs = div.querySelectorAll('[name^="cta_buttons["]');
                inputs.forEach(input => {
                    const name = input.name;
                    const newName = name.replace(/cta_buttons\[\d+\]/, `cta_buttons[${index}]`);
                    input.name = newName;
                });
            });

            ctaButtonIndex = buttons.length;
            updatePreview();
        }

        // Initialize preview on page load
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();
        });
    </script>
@endpush
