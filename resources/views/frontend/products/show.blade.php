@extends('frontend.layouts.app')

@section('title', $product->name)
@section('description', $product->short_description)

@section('content')
    <div class="bg-gray-50 min-h-screen">

        {{-- ── Breadcrumb ─────────────────────────────────────── --}}
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <nav class="flex items-center gap-1.5 text-xs text-gray-500 flex-wrap" aria-label="Breadcrumb">
                    @foreach ($breadcrumbs as $crumb)
                        @if ($loop->last)
                            <span class="text-gray-800 font-medium truncate max-w-[180px] sm:max-w-xs" aria-current="page">
                                {{ $crumb['name'] }}
                            </span>
                        @else
                            <a href="{{ $crumb['url'] }}" class="hover:text-primary transition-colors shrink-0">
                                {{ $crumb['name'] }}
                            </a>
                            <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 space-y-6">

            {{-- ══════════════════════════════════════════════════════════ --}}
            {{-- ── Product Main Block ─────────────────────────────────── --}}
            {{-- ══════════════════════════════════════════════════════════ --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid lg:grid-cols-2">

                    {{-- ── Left: Image Gallery ─────────────────────────── --}}
                    <div class="p-5 sm:p-7 lg:p-8 border-b lg:border-b-0 lg:border-r border-gray-100">
                        @php
                            $images = array_values(
                                array_filter(
                                    array_merge([$product->featured_image_url], $product->gallery_images_urls ?? []),
                                ),
                            );
                            if (empty($images)) {
                                $images = [asset('images/placeholder.jpg')];
                            }
                        @endphp

                        {{-- Main image --}}
                        <div class="relative bg-gray-50 rounded-xl overflow-hidden mb-4 group" style="aspect-ratio:1/1;">
                            <img id="mainImage" src="{{ $images[0] }}" alt="{{ $product->name }}"
                                class="w-full h-full object-contain p-5 transition-transform duration-500 group-hover:scale-[1.04]">

                            {{-- Discount badge --}}
                            @if ($product->compare_price > $product->price)
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <span
                                        class="inline-flex items-center bg-primary text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                            @endif

                            {{-- Out of stock overlay --}}
                            @if ($product->stock_status !== 'in_stock')
                                <div
                                    class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center">
                                    <span
                                        class="bg-gray-800 text-white text-xs font-bold px-4 py-2 rounded-full tracking-wide">
                                        OUT OF STOCK
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Thumbnails --}}
                        @if (count($images) > 1)
                            <div class="grid grid-cols-5 gap-2">
                                @foreach ($images as $idx => $img)
                                    <button type="button" data-thumb data-src="{{ $img }}"
                                        class="rounded-lg overflow-hidden border-2 transition-all duration-200 group/thumb
                                               {{ $idx === 0 ? 'border-primary ring-2 ring-primary/20' : 'border-gray-200 hover:border-gray-400' }}"
                                        style="aspect-ratio:1/1;" aria-label="View image {{ $idx + 1 }}">
                                        <img src="{{ $img }}" alt="View {{ $idx + 1 }}"
                                            class="w-full h-full object-contain p-1 bg-gray-50">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- ── Right: Product Info ─────────────────────────── --}}
                    <div class="p-5 sm:p-7 lg:p-8 flex flex-col gap-5">

                        {{-- Title --}}
                        <div>
                            @if ($product->sku)
                                <p class="text-[11px] text-gray-400 uppercase tracking-widest mb-2">SKU:
                                    {{ $product->sku }}</p>
                            @endif

                            <h1 class="text-xl sm:text-2xl lg:text-[1.65rem] font-bold text-gray-900 leading-snug mb-3">
                                {{ $product->name }}
                            </h1>

                            {{-- Rating --}}
                            @if ($product->average_rating > 0)
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <div class="flex gap-0.5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= floor($product->average_rating) ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-200 text-gray-200' }}"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-700">{{ number_format($product->average_rating, 1) }}</span>
                                    <button type="button" id="jump-to-reviews"
                                        class="text-sm text-primary hover:underline">
                                        {{ $product->rating_count }} {{ Str::plural('review', $product->rating_count) }}
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Price block --}}
                        <div class="flex items-end gap-3 flex-wrap">
                            <span class="text-3xl font-bold text-gray-900 leading-none">
                                <span class="font-bengali">৳</span>{{ number_format($product->price, 0) }}
                            </span>
                            @if ($product->compare_price > $product->price)
                                <span class="text-lg text-gray-400 line-through leading-none">
                                    <span class="font-bengali">৳</span>{{ number_format($product->compare_price, 0) }}
                                </span>
                                <span
                                    class="text-xs bg-red-50 text-red-600 border border-red-200 px-2.5 py-1 rounded-full font-semibold">
                                    Save <span
                                        class="font-bengali">৳</span>{{ number_format($product->compare_price - $product->price, 0) }}
                                </span>
                            @endif
                        </div>

                        {{-- Stock badge --}}
                        <div>
                            @if ($product->stock_status === 'in_stock')
                                <span
                                    class="inline-flex items-center gap-2 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    In Stock
                                    @if ($product->quantity > 0 && $product->quantity <= 10)
                                        &nbsp;· Only {{ $product->quantity }} left
                                    @endif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-2 text-sm font-medium text-red-700 bg-red-50 border border-red-200 px-3 py-1.5 rounded-full">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        {{-- Short description --}}
                        @if ($product->short_description)
                            <p class="text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-4">
                                {{ $product->short_description }}
                            </p>
                        @endif

                        {{-- ── Actions ─────────────────────────────────── --}}
                        @if ($product->stock_status === 'in_stock')
                            <div class="space-y-3.5">
                                {{-- Quantity --}}
                                <div class="flex items-center gap-4">
                                    <label for="quantity" class="text-sm font-medium text-gray-700 min-w-max">Qty</label>
                                    <div class="flex items-center bg-gray-100 rounded-xl overflow-hidden h-11 w-fit">
                                        <button id="qty-minus" type="button"
                                            class="w-11 h-11 flex items-center justify-center text-gray-500 hover:bg-gray-200 hover:text-gray-900 transition-colors"
                                            aria-label="Decrease quantity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity" value="1" min="1"
                                            max="{{ $product->quantity }}"
                                            class="w-14 h-11 text-center bg-transparent border-0 focus:ring-0 font-semibold text-gray-900 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                            aria-label="Quantity">
                                        <button id="qty-plus" type="button"
                                            class="w-11 h-11 flex items-center justify-center text-gray-500 hover:bg-gray-200 hover:text-gray-900 transition-colors"
                                            aria-label="Increase quantity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Primary CTAs --}}
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1"
                                        id="addCartForm">
                                        @csrf
                                        <input type="hidden" name="quantity" id="cartQty" value="1">
                                        <button type="submit"
                                            class="btn-shine w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3.5 px-6 rounded-xl transition-colors flex items-center justify-center gap-2 text-sm shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Add to Cart
                                        </button>
                                    </form>

                                    <form action="{{ route('checkout.buy-now', $product->id) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" id="buyQty" value="1">
                                        <input type="hidden" name="buy_now" value="1">
                                        <button type="submit"
                                            class="w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-3.5 px-6 rounded-xl transition-colors text-sm shadow-sm">
                                            Buy Now
                                        </button>
                                    </form>
                                </div>

                                {{-- Wishlist --}}
                                @auth
                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 text-sm text-gray-600 hover:text-primary border border-gray-200 hover:border-primary rounded-xl py-2.5 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            Save to Wishlist
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="w-full flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-primary border border-gray-200 hover:border-primary rounded-xl py-2.5 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Login to Save
                                    </a>
                                @endauth
                            </div>
                        @else
                            <div class="space-y-3">
                                <button disabled
                                    class="w-full bg-gray-200 text-gray-500 font-semibold py-3.5 rounded-xl cursor-not-allowed text-sm">
                                    Out of Stock
                                </button>
                                @auth
                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 text-sm text-gray-600 hover:text-primary border border-gray-200 hover:border-primary rounded-xl py-2.5 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            Notify Me When Available
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        @endif

                        {{-- Product meta --}}
                        @if ($product->category || $product->model_number || $product->warranty_period)
                            <dl class="border-t border-gray-100 pt-4 grid grid-cols-[auto_1fr] gap-x-6 gap-y-2.5 text-sm">
                                @if ($product->category)
                                    <dt class="text-gray-400 font-medium">Category</dt>
                                    <dd>
                                        <a href="{{ route('categories.show', $product->category->slug) }}"
                                            class="text-primary hover:underline font-medium">
                                            {{ $product->category->name }}
                                        </a>
                                    </dd>
                                @endif
                                @if ($product->model_number)
                                    <dt class="text-gray-400 font-medium">Model</dt>
                                    <dd class="font-medium text-gray-800">{{ $product->model_number }}</dd>
                                @endif
                                @if ($product->warranty_period)
                                    <dt class="text-gray-400 font-medium">Warranty</dt>
                                    <dd class="font-medium text-gray-800">{{ $product->warranty_period }}
                                        {{ $product->warranty_type }}</dd>
                                @endif
                            </dl>
                        @endif

                        {{-- Trust badges --}}
                        <div class="grid grid-cols-3 gap-3 border-t border-gray-100 pt-5">
                            <div class="flex flex-col items-center gap-1.5 text-center">
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <span class="text-[11px] text-gray-500 leading-tight font-medium">Genuine<br>Product</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 text-center">
                                <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <span class="text-[11px] text-gray-500 leading-tight font-medium">Secure<br>Payment</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 text-center">
                                <div class="w-10 h-10 bg-orange-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <span class="text-[11px] text-gray-500 leading-tight font-medium">Fast<br>Delivery</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════════ --}}
            {{-- ── Tabs: Description / Specifications / Reviews ──────── --}}
            {{-- ══════════════════════════════════════════════════════════ --}}
            <div id="tabs" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Tab nav --}}
                <div class="border-b border-gray-100 px-5 sm:px-7 lg:px-8">
                    <nav class="flex gap-0 overflow-x-auto no-scrollbar -mb-px" aria-label="Product information tabs">
                        <button type="button" data-tab-btn="desc"
                            class="shrink-0 py-4 px-1 mr-6 text-sm font-semibold border-b-2 border-primary text-primary whitespace-nowrap transition-colors">
                            Description
                        </button>
                        <button type="button" data-tab-btn="specs"
                            class="shrink-0 py-4 px-1 mr-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-800 whitespace-nowrap transition-colors">
                            Specifications
                        </button>
                        <button type="button" data-tab-btn="reviews"
                            class="shrink-0 py-4 px-1 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-800 whitespace-nowrap transition-colors">
                            Reviews
                            @if ($product->rating_count > 0)
                                <span
                                    class="ml-1.5 text-xs bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded-full">{{ $product->rating_count }}</span>
                            @endif
                        </button>
                    </nav>
                </div>

                <div class="p-5 sm:p-7 lg:p-8">

                    {{-- ── Description ──────────────────────── --}}
                    <div data-tab-panel="desc">
                        @if ($product->description)
                            <div
                                class="prose prose-sm sm:prose max-w-none text-gray-700
                                    prose-headings:font-semibold prose-headings:text-gray-900
                                    prose-a:text-primary prose-a:no-underline hover:prose-a:underline
                                    prose-img:rounded-lg">
                                {!! $product->description !!}
                            </div>
                        @else
                            <p class="text-gray-400 text-sm py-4">No description available.</p>
                        @endif
                    </div>

                    {{-- ── Specifications ────────────────────── --}}
                    <div data-tab-panel="specs" class="hidden">
                        @php
                            $specs = array_filter(
                                $product->specifications_array ?? [],
                                fn($s) => !empty($s['key']) && !empty($s['value']),
                            );
                            $hasSpecs =
                                $product->sku || $product->model_number || $product->weight || count($specs) > 0;
                        @endphp
                        @if ($hasSpecs)
                            <div class="rounded-xl border border-gray-200 overflow-hidden">
                                <table class="w-full text-sm">
                                    <tbody class="divide-y divide-gray-100">
                                        @if ($product->sku)
                                            <tr class="odd:bg-gray-50/60">
                                                <td class="py-3 px-5 text-gray-500 font-medium w-2/5 sm:w-1/3">SKU</td>
                                                <td class="py-3 px-5 text-gray-900 font-medium">{{ $product->sku }}</td>
                                            </tr>
                                        @endif
                                        @if ($product->model_number)
                                            <tr class="odd:bg-gray-50/60">
                                                <td class="py-3 px-5 text-gray-500 font-medium w-2/5 sm:w-1/3">Model</td>
                                                <td class="py-3 px-5 text-gray-900 font-medium">
                                                    {{ $product->model_number }}</td>
                                            </tr>
                                        @endif
                                        @if ($product->weight)
                                            <tr class="odd:bg-gray-50/60">
                                                <td class="py-3 px-5 text-gray-500 font-medium w-2/5 sm:w-1/3">Weight</td>
                                                <td class="py-3 px-5 text-gray-900 font-medium">{{ $product->weight }} kg
                                                </td>
                                            </tr>
                                        @endif
                                        @foreach ($specs as $spec)
                                            <tr class="odd:bg-gray-50/60">
                                                <td class="py-3 px-5 text-gray-500 font-medium w-2/5 sm:w-1/3">
                                                    {{ $spec['key'] }}</td>
                                                <td class="py-3 px-5 text-gray-900 font-medium">{{ $spec['value'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-400 text-sm py-4">No specifications available.</p>
                        @endif
                    </div>

                    {{-- ── Reviews ───────────────────────────── --}}
                    <div data-tab-panel="reviews" class="hidden">
                        @if ($product->reviews->count() > 0)
                            {{-- Rating summary --}}
                            <div class="flex items-center gap-5 mb-8 p-5 bg-gray-50 rounded-xl">
                                <div class="text-center min-w-[80px]">
                                    <div class="text-4xl font-bold text-gray-900 leading-none mb-1">
                                        {{ number_format($product->average_rating, 1) }}
                                    </div>
                                    <div class="flex justify-center gap-0.5 mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= round($product->average_rating) ? 'fill-yellow-400' : 'fill-gray-200' }}"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $product->rating_count }}
                                        {{ Str::plural('review', $product->rating_count) }}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @foreach ($product->reviews as $review)
                                    <div
                                        class="border border-gray-100 rounded-xl p-5 hover:border-gray-200 transition-colors">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div
                                                    class="w-9 h-9 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-sm shrink-0">
                                                    {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-gray-900 text-sm truncate">
                                                        {{ $review->user->name ?? 'Anonymous' }}
                                                    </p>
                                                    <div class="flex gap-0.5 mt-0.5">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-yellow-400' : 'fill-gray-200' }}"
                                                                viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400 shrink-0">
                                                {{ $review->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        @if ($review->comment)
                                            <p class="text-gray-700 text-sm leading-relaxed mt-3 pl-12">
                                                {{ $review->comment }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-14">
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 font-medium text-sm mb-1">No reviews yet</p>
                                <p class="text-xs text-gray-400">Be the first to share your experience with this product
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════════ --}}
            {{-- ── Related Products ───────────────────────────────────── --}}
            {{-- ══════════════════════════════════════════════════════════ --}}
            @if ($relatedProducts->count() > 0)
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-lg font-bold text-gray-900">Related Products</h2>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                        @foreach ($relatedProducts as $related)
                            @php
                                $relImages = is_array($related->featured_images)
                                    ? $related->featured_images
                                    : json_decode($related->featured_images ?? '[]', true);
                                $relImg = !empty($relImages) ? $relImages[0] : 'products/placeholder.jpg';
                            @endphp
                            <a href="{{ route('product.show', $related->slug) }}"
                                class="group bg-white rounded-xl border border-gray-200 hover:border-primary/50 hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col">
                                <div class="bg-gray-50 p-3 overflow-hidden" style="aspect-ratio:1/1;">
                                    <img src="{{ asset('storage/' . $relImg) }}" alt="{{ $related->name_en }}"
                                        loading="lazy"
                                        class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-3 flex flex-col flex-1">
                                    <h3
                                        class="text-xs sm:text-sm font-medium text-gray-900 group-hover:text-primary transition-colors line-clamp-2 mb-2 flex-1 leading-snug">
                                        {{ $related->name_en }}
                                    </h3>
                                    <div class="flex items-baseline gap-1.5 flex-wrap">
                                        <span class="font-bold text-sm text-gray-900">
                                            <span class="font-bengali">৳</span>{{ number_format($related->price, 0) }}
                                        </span>
                                        @if ($related->compare_price > $related->price)
                                            <span class="text-xs text-gray-400 line-through">
                                                <span
                                                    class="font-bengali">৳</span>{{ number_format($related->compare_price, 0) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>{{-- /container --}}
    </div>{{-- /bg-gray-50 --}}

    @push('scripts')
        <script>
            (function() {
                'use strict';

                document.addEventListener('DOMContentLoaded', function() {

                    // ── Image gallery ─────────────────────────────────────────────
                    var mainImg = document.getElementById('mainImage');
                    var thumbs = document.querySelectorAll('[data-thumb]');

                    function setThumbActive(active) {
                        thumbs.forEach(function(t) {
                            t.classList.remove('border-primary', 'ring-2', 'ring-primary/20');
                            t.classList.add('border-gray-200');
                        });
                        active.classList.remove('border-gray-200');
                        active.classList.add('border-primary', 'ring-2', 'ring-primary/20');
                    }

                    thumbs.forEach(function(thumb) {
                        thumb.addEventListener('click', function() {
                            if (mainImg) {
                                mainImg.src = this.dataset.src;
                                setThumbActive(this);
                            }
                        });
                    });

                    // ── Quantity stepper ──────────────────────────────────────────
                    var qtyInput = document.getElementById('quantity');
                    var cartQty = document.getElementById('cartQty');
                    var buyQty = document.getElementById('buyQty');

                    function syncQty(val) {
                        if (!qtyInput) return;
                        var max = parseInt(qtyInput.max, 10) || 9999;
                        var n = Math.max(1, Math.min(max, parseInt(val, 10) || 1));
                        qtyInput.value = n;
                        if (cartQty) cartQty.value = n;
                        if (buyQty) buyQty.value = n;
                    }

                    var btnMinus = document.getElementById('qty-minus');
                    var btnPlus = document.getElementById('qty-plus');
                    if (btnMinus) btnMinus.addEventListener('click', function() {
                        syncQty(+qtyInput.value - 1);
                    });
                    if (btnPlus) btnPlus.addEventListener('click', function() {
                        syncQty(+qtyInput.value + 1);
                    });
                    if (qtyInput) qtyInput.addEventListener('input', function() {
                        syncQty(this.value);
                    });

                    // ── Tabs ──────────────────────────────────────────────────────
                    var tabBtns = document.querySelectorAll('[data-tab-btn]');
                    var tabPanels = document.querySelectorAll('[data-tab-panel]');

                    window.activateTab = function(name) {
                        tabBtns.forEach(function(btn) {
                            var on = btn.dataset.tabBtn === name;
                            btn.classList.toggle('border-primary', on);
                            btn.classList.toggle('text-primary', on);
                            btn.classList.toggle('font-semibold', on);
                            btn.classList.toggle('border-transparent', !on);
                            btn.classList.toggle('text-gray-500', !on);
                        });
                        tabPanels.forEach(function(panel) {
                            panel.classList.toggle('hidden', panel.dataset.tabPanel !== name);
                        });
                    };

                    tabBtns.forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            window.activateTab(this.dataset.tabBtn);
                        });
                    });

                    // Jump to reviews link
                    var jumpBtn = document.getElementById('jump-to-reviews');
                    if (jumpBtn) {
                        jumpBtn.addEventListener('click', function() {
                            window.activateTab('reviews');
                            var tabs = document.getElementById('tabs');
                            if (tabs) tabs.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        });
                    }

                    // Honour URL hash on load
                    if (window.location.hash === '#reviews') {
                        window.activateTab('reviews');
                    }
                });
            }());
        </script>
    @endpush
@endsection
