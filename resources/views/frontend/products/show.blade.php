@extends('frontend.layouts.app')

@section('title', $product->name)
@section('description', $product->short_description)

@section('content')
    <div class="min-h-screen bg-gray-50">
        {{-- Breadcrumb --}}
        <div class="bg-white border-b">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <nav class="flex items-center space-x-2 text-sm text-gray-600">
                    @foreach ($breadcrumbs as $crumb)
                        @if ($loop->last)
                            <span class="text-gray-900 font-medium truncate max-w-xs">{{ $crumb['name'] }}</span>
                        @else
                            <a href="{{ $crumb['url'] }}" class="hover:text-primary">{{ $crumb['name'] }}</a>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- Product Details --}}
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid lg:grid-cols-2 gap-8">

                {{-- Images --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-lg border border-gray-200 p-4 aspect-square">
                        <img id="mainImage" src="{{ $product->featured_image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-contain">
                    </div>

                    @php
                        $images = array_merge([$product->featured_image_url], $product->gallery_images_urls ?? []);
                    @endphp

                    @if (count($images) > 1)
                        <div class="grid grid-cols-5 gap-2">
                            @foreach ($images as $index => $image)
                                <button onclick="changeImage('{{ $image }}')"
                                    class="border-2 rounded-lg overflow-hidden {{ $loop->first ? 'border-primary' : 'border-gray-200 hover:border-primary' }}"
                                    data-image-btn>
                                    <img src="{{ $image }}" alt="View {{ $index + 1 }}"
                                        class="w-full aspect-square object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="space-y-6">
                    {{-- Title & Price --}}
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>

                        @if ($product->sku)
                            <p class="text-sm text-gray-500 mb-4">SKU: {{ $product->sku }}</p>
                        @endif

                        <div class="flex items-baseline gap-3 mb-2">
                            <span class="text-3xl font-bold text-gray-900"><span
                                    class="font-bengali">৳</span>{{ number_format($product->price, 0) }}</span>
                            @if ($product->compare_price > $product->price)
                                <span class="text-lg text-gray-500 line-through"><span
                                        class="font-bengali">৳</span>{{ number_format($product->compare_price, 0) }}</span>
                                <span class="text-sm bg-red-100 text-red-700 px-2 py-1 rounded font-semibold">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>

                        @if ($product->average_rating > 0)
                            <div class="flex items-center gap-2">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($product->average_rating) ? 'fill-current' : 'fill-gray-300' }}"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600">{{ number_format($product->average_rating, 1) }}
                                    ({{ $product->rating_count }} reviews)</span>
                            </div>
                        @endif
                    </div>

                    {{-- Stock Status --}}
                    <div
                        class="p-4 rounded-lg {{ $product->stock_status === 'in_stock' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        @if ($product->stock_status === 'in_stock')
                            <div class="flex items-center text-green-700">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold">In Stock • {{ $product->quantity }} available</span>
                            </div>
                        @else
                            <div class="flex items-center text-red-700">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold">Out of Stock</span>
                            </div>
                        @endif
                    </div>

                    {{-- Description --}}
                    @if ($product->short_description)
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-700">{{ $product->short_description }}</p>
                        </div>
                    @endif

                    {{-- Actions --}}
                    @if ($product->stock_status === 'in_stock')
                        <div class="space-y-3">
                            {{-- Quantity --}}
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-medium text-gray-700">Quantity:</span>
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button onclick="updateQty(-1)" class="px-3 py-2 hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1"
                                        max="{{ $product->quantity }}"
                                        class="w-16 text-center border-0 focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none">
                                    <button onclick="updateQty(1)" class="px-3 py-2 hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="grid grid-cols-2 gap-3">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addCartForm">
                                    @csrf
                                    <input type="hidden" name="quantity" id="cartQty" value="1">
                                    <button type="submit"
                                        class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add to Cart
                                    </button>
                                </form>

                                <form action="{{ route('checkout.buy-now', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" id="buyQty" value="1">
                                    <input type="hidden" name="buy_now" value="1">
                                    <button type="submit"
                                        class="w-full bg-accent hover:bg-accent/90 text-white font-semibold py-3 rounded-lg transition-colors">
                                        Buy Now
                                    </button>
                                </form>
                            </div>

                            @auth
                                <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full border-2 border-gray-300 hover:border-primary text-gray-700 hover:text-primary font-medium py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Add to Wishlist
                                    </button>
                                </form>
                            @endauth
                        </div>
                    @else
                        <button disabled
                            class="w-full bg-gray-300 text-gray-600 font-semibold py-3 rounded-lg cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif

                    {{-- Details --}}
                    <div class="border-t pt-6 space-y-2 text-sm">
                        @if ($product->category)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Category</span>
                                <a href="{{ route('categories.show', $product->category->slug) }}"
                                    class="text-primary hover:underline">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                        @endif
                        @if ($product->model_number)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Model</span>
                                <span class="font-medium">{{ $product->model_number }}</span>
                            </div>
                        @endif
                        @if ($product->warranty_period)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Warranty</span>
                                <span class="font-medium">{{ $product->warranty_period }}
                                    {{ $product->warranty_type }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="mt-12">
                <div class="border-b">
                    <nav class="flex gap-8">
                        <button onclick="switchTab('desc')" data-tab="desc"
                            class="tab-btn py-4 border-b-2 font-medium border-primary text-primary">
                            Description
                        </button>
                        <button onclick="switchTab('specs')" data-tab="specs"
                            class="tab-btn py-4 border-b-2 font-medium border-transparent text-gray-600 hover:text-gray-900">
                            Specifications
                        </button>
                        <button onclick="switchTab('reviews')" data-tab="reviews"
                            class="tab-btn py-4 border-b-2 font-medium border-transparent text-gray-600 hover:text-gray-900">
                            Reviews ({{ $product->rating_count }})
                        </button>
                    </nav>
                </div>

                <div class="py-8">
                    {{-- Description --}}
                    <div id="desc-content" class="tab-content">
                        @if ($product->description)
                            <div class="prose max-w-none">{!! $product->description !!}</div>
                        @else
                            <p class="text-gray-500">No description available.</p>
                        @endif
                    </div>

                    {{-- Specifications --}}
                    <div id="specs-content" class="tab-content hidden">
                        <div class="bg-white rounded-lg border divide-y">
                            @if ($product->sku)
                                <div class="flex py-3 px-4">
                                    <span class="w-1/3 text-gray-600">SKU</span>
                                    <span class="w-2/3 font-medium">{{ $product->sku }}</span>
                                </div>
                            @endif
                            @if ($product->model_number)
                                <div class="flex py-3 px-4">
                                    <span class="w-1/3 text-gray-600">Model</span>
                                    <span class="w-2/3 font-medium">{{ $product->model_number }}</span>
                                </div>
                            @endif
                            @if ($product->weight)
                                <div class="flex py-3 px-4">
                                    <span class="w-1/3 text-gray-600">Weight</span>
                                    <span class="w-2/3 font-medium">{{ $product->weight }} kg</span>
                                </div>
                            @endif
                            @foreach ($product->specifications_array ?? [] as $spec)
                                @if (isset($spec['key']) && isset($spec['value']))
                                    <div class="flex py-3 px-4">
                                        <span class="w-1/3 text-gray-600">{{ $spec['key'] }}</span>
                                        <span class="w-2/3 font-medium">{{ $spec['value'] }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Reviews --}}
                    <div id="reviews-content" class="tab-content hidden">
                        @if ($product->reviews->count() > 0)
                            <div class="space-y-6">
                                @foreach ($product->reviews as $review)
                                    <div class="bg-white rounded-lg border p-6">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <div class="font-semibold text-gray-900">
                                                    {{ $review->user->name ?? 'Anonymous' }}</div>
                                                <div class="flex text-yellow-400 mt-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'fill-gray-300' }}"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span
                                                class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <p class="text-gray-500 mb-4">No reviews yet</p>
                                <button class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark">
                                    Be the first to review
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if ($relatedProducts->count() > 0)
                <div class="mt-12 pt-12 border-t">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($relatedProducts as $related)
                            <a href="{{ route('product.show', $related->slug) }}"
                                class="group bg-white rounded-lg border hover:border-primary transition-colors overflow-hidden">
                                <div class="aspect-square bg-gray-50 p-4">
                                    @php
                                        $featuredImages = is_array($related->featured_images)
                                            ? $related->featured_images
                                            : json_decode($related->featured_images ?? '[]', true);
                                        $image = !empty($featuredImages)
                                            ? $featuredImages[0]
                                            : 'products/placeholder.jpg';
                                    @endphp
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $related->name_en }}"
                                        class="w-full h-full object-contain group-hover:scale-105 transition-transform">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-medium text-sm mb-2 line-clamp-2 group-hover:text-primary">
                                        {{ $related->name_en }}</h3>
                                    <div class="flex items-baseline gap-2">
                                        <span class="font-bold"><span
                                                class="font-bengali">৳</span>{{ number_format($related->price, 0) }}</span>
                                        @if ($related->compare_price > $related->price)
                                            <span class="text-xs text-gray-500 line-through"><span
                                                    class="font-bengali">৳</span>{{ number_format($related->compare_price, 0) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            // Image switching
            function changeImage(src) {
                document.getElementById('mainImage').src = src;
                document.querySelectorAll('[data-image-btn]').forEach(btn => {
                    btn.classList.remove('border-primary');
                    btn.classList.add('border-gray-200');
                });
                event.target.closest('[data-image-btn]').classList.add('border-primary');
                event.target.closest('[data-image-btn]').classList.remove('border-gray-200');
            }

            // Quantity
            function updateQty(change) {
                const input = document.getElementById('quantity');
                const newVal = Math.max(1, Math.min(parseInt(input.max), parseInt(input.value) + change));
                input.value = newVal;
                document.getElementById('cartQty').value = newVal;
                document.getElementById('buyQty').value = newVal;
            }

            document.getElementById('quantity').addEventListener('input', function() {
                const val = parseInt(this.value) || 1;
                document.getElementById('cartQty').value = val;
                document.getElementById('buyQty').value = val;
            });

            // Tabs
            function switchTab(tabName) {
                document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('border-primary', 'text-primary');
                    btn.classList.add('border-transparent', 'text-gray-600');
                });

                document.getElementById(tabName + '-content').classList.remove('hidden');
                document.querySelector(`[data-tab="${tabName}"]`).classList.add('border-primary', 'text-primary');
                document.querySelector(`[data-tab="${tabName}"]`).classList.remove('border-transparent', 'text-gray-600');
            }
        </script>
    @endpush
@endsection
