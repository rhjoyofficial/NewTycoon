@extends('frontend.layouts.app')

@section('title', 'Catalogs')
@section('description', 'Explore our extensive catalogs featuring a wide range of products. Browse through our
    collections and discover the perfect items for your lifestyle.')

@section('content')
    <div class="bg-gray-50 min-h-screen max-w-8xl mx-auto">

        {{-- Hero Section --}}
        <div class="bg-white border-b border-primary px-4 py-12 text-left">
            <h1 class="text-4xl font-bold text-primary mb-4">
                Our Catalogs
            </h1>
            <p class="text-gray-600 max-w-2xl text-left">
                Discover detailed company brochures and business profiles. Click any catalog to open and explore the full
                PDF in a new tab.
            </p>
        </div>

        {{-- Catalog Grid --}}
        <div class="bg-white px-4 py-12">
            @if ($catalogs->count() > 0)
                <div id="catalogGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

                    @foreach ($catalogs as $catalog)
                        <a href="{{ route('catalog.view', $catalog->id) }}" target="_blank" rel="noopener noreferrer"
                            class="catalog-card bg-white shadow-sm hover:shadow-lg transition duration-300 overflow-hidden group block"
                            data-title="{{ strtolower($catalog->title) }}">

                            {{-- Thumbnail --}}
                            <div class="relative h-56 overflow-hidden bg-gray-100">
                                @if ($catalog->thumbnail)
                                    <img src="{{ asset('storage/' . $catalog->thumbnail) }}" alt="{{ $catalog->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                        loading="lazy">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                                        No Preview Available
                                    </div>
                                @endif

                                {{-- Overlay --}}
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition duration-300 flex items-center justify-center">
                                    <span
                                        class="opacity-0 group-hover:opacity-100 text-white text-sm font-medium border px-4 py-2 rounded-lg transition duration-300">
                                        Open Catalog
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-2">
                                    {{ $catalog->title }}
                                </h3>

                                @if ($catalog->company_name)
                                    <p class="text-sm text-gray-500">
                                        {{ $catalog->company_name }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endforeach

                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $catalogs->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">
                        No catalogs available
                    </h3>
                    <p class="text-gray-500">
                        Please check back later.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
