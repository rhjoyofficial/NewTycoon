{{-- resources/views/frontend/home.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'Hi-Tech Park')
@section('content')
    @include('frontend.partials.hero')
    <x-category-slider :categories="$categories" />
    <x-products :featuredProducts="$featuredProducts" />
    @include('components.offer-products')

    @foreach ($sections as $section)
        @if ($section->type === 'product_slider')
            <x-product-slider :slidingProducts="$section->products" :banner="$section->banner" title="{{ $section->title }}"
                sliderId="section-{{ $section->id }}" :slidesPerView="$section->settings['slidesPerView'] ?? 5" :autoPlay="$section->settings['autoPlay'] ?? true" :showNavigation="$section->settings['showNavigation'] ?? true"
                :showPagination="$section->settings['showPagination'] ?? false" cardStyle="minimal" />
        @elseif($section->type === 'banner')
            @if ($section->banner)
                <x-ads-banner :banner="$section->banner" />
            @endif
        @endif
    @endforeach

    {{-- The old static banners and product sliders below are removed --}}
    {{-- <x-ads-banner ... />  (removed) --}}
    {{-- <x-product-slider ... /> (removed) --}}
    {{-- ... etc --}}
@endsection
