{{-- resources/views/frontend/home.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'Hi-Tech Park')
@section('content')
    @include('frontend.partials.hero')
    <x-category-slider :categories="$categories" />
    <x-products :featuredProducts="$featuredProducts" />
    @foreach ($offers as $offer)
        @php $offerProducts = $offer->getSourceProducts(); @endphp
        @include('components.offer-products', ['offer' => $offer, 'offerProducts' => $offerProducts])
    @endforeach

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

@endsection
