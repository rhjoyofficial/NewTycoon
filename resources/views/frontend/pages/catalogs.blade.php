@extends('frontend.layouts.app')

@section('title', 'Catalogs')
@section('description',
    'Explore our extensive catalogs featuring a wide range of products. Browse through our
    collections and discover the perfect items for your lifestyle.')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-12">
        {{-- Hero Section --}}
        <div
            class="relative overflow-hidden bg-gradient-to-br from-primary/10 via-white to-accent/10 rounded-3xl p-12 mb-12">
            {{-- Decorative Elements --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent/5 rounded-full -ml-48 -mb-48"></div>

            <div class="relative z-10 max-w-3xl">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-primary font-semibold font-inter uppercase tracking-wider">Product Showcase</span>
                </div>

                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 font-poppins leading-tight">
                    Explore Our <br>
                    <span class="text-primary">Catalogs</span>
                </h1>

                <p class="text-lg text-gray-600 max-w-2xl font-inter leading-relaxed">
                    Discover detailed company brochures and business profiles. Click any catalog to open and explore the
                    full PDF in a new tab.
                </p>

                {{-- Stats --}}
                <div class="flex gap-8 mt-8">
                    <div>
                        <div class="text-3xl font-bold text-primary font-poppins">{{ $catalogs->total() }}+</div>
                        <div class="text-sm text-gray-600 font-inter">Catalogs Available</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-primary font-poppins">Free</div>
                        <div class="text-sm text-gray-600 font-inter">Instant Access</div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Catalog Grid --}}
        @if ($catalogs->count() > 0)
            <div id="catalogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($catalogs as $catalog)
                    <a href="{{ route('catalog.view', $catalog->id) }}" target="_blank" rel="noopener noreferrer"
                        class="catalog-card group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                        data-title="{{ strtolower($catalog->title) }}">

                        {{-- Thumbnail Container --}}
                        <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50">
                            @if ($catalog->thumbnail)
                                <img src="{{ asset('storage/' . $catalog->thumbnail) }}" alt="{{ $catalog->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                    loading="lazy">
                            @else
                                <div class="flex flex-col items-center justify-center h-full">
                                    <svg class="w-16 h-16 text-gray-300 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-400 text-sm font-inter">No Preview</span>
                                </div>
                            @endif

                            {{-- PDF Badge --}}
                            <div
                                class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg shadow-sm">
                                <span class="text-xs font-semibold text-primary font-inter">PDF</span>
                            </div>

                            {{-- Hover Overlay --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-start p-6">
                                <span class="text-white font-medium font-inter flex items-center gap-2">
                                    Open Catalog
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            <h3
                                class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 font-poppins group-hover:text-primary transition-colors">
                                {{ $catalog->title }}
                            </h3>

                            @if ($catalog->company_name)
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <p class="text-sm text-gray-600 font-inter">
                                        {{ $catalog->company_name }}
                                    </p>
                                </div>
                            @endif

                            {{-- Meta Info --}}
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <div class="flex items-center gap-1 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-xs font-inter">{{ $catalog->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="flex items-center gap-1 text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span class="text-xs font-inter font-medium">View PDF</span>
                                </div>
                            </div>
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
            <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">No Catalogs Available</h3>
                    <p class="text-gray-600 font-inter mb-6">We're currently updating our catalog collection. Please check
                        back later for new additions.</p>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-inter font-medium hover:bg-primary-dark transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Return Home
                    </a>
                </div>
            </div>
        @endif


    </div>
@endsection
