@extends('frontend.layouts.app')

@section('title', 'Shop by Category')
@section('description', 'Browse our product categories')

@section('content')
    <div class="min-h-screen bg-gray-50">
        {{-- Header --}}
        <div class="bg-white border-b">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Shop by Category</h1>
                <p class="text-gray-600">Find products organized by category</p>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- All Categories --}}
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">All Categories</h2>
                    <p class="text-sm text-gray-600">{{ $categories->count() }} categories</p>
                </div>

                @if ($categories->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($categories as $category)
                            {{-- Category Folder Card --}}
                            <div
                                class="bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-md transition-all duration-200 overflow-hidden group">
                                {{-- Folder Header --}}
                                <div class="p-4 border-b border-gray-100">
                                    <div class="flex items-start space-x-3">
                                        {{-- Folder Icon --}}
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" />
                                            </svg>
                                        </div>

                                        {{-- Folder Info --}}
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('categories.show', $category->slug) }}"
                                                class="text-lg font-semibold text-gray-900 hover:text-primary transition-colors truncate block">
                                                {{ $category->name }}
                                            </a>
                                            @if ($category->description)
                                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                                    {{ $category->description }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Subcategories (Level 2) --}}
                                @if ($category->children && $category->children->count() > 0)
                                    <div class="p-3 bg-gray-50/50">
                                        <div class="space-y-1">
                                            @foreach ($category->children as $child)
                                                <div class="group/item">
                                                    <a href="{{ route('categories.show', $child->slug) }}"
                                                        class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-white hover:shadow-sm transition-all duration-150">
                                                        <div class="flex items-center space-x-2 min-w-0 flex-1">
                                                            {{-- Subfolder Icon --}}
                                                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 group-hover/item:text-primary"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z" />
                                                            </svg>
                                                            <span
                                                                class="text-sm text-gray-600 group-hover/item:text-primary truncate">
                                                                {{ $child->name }}
                                                            </span>
                                                        </div>
                                                        {{-- Child product count --}}
                                                        @if (($child->products_count ?? 0) > 0)
                                                            <span
                                                                class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded flex-shrink-0 ml-2">
                                                                {{ $child->products_count }}
                                                            </span>
                                                        @endif
                                                    </a>

                                                    {{-- Sub-subcategories (Level 3) --}}
                                                    @if ($child->children && $child->children->count() > 0)
                                                        <div class="ml-6 mt-1 space-y-1">
                                                            @foreach ($child->children as $grandchild)
                                                                <a href="{{ route('categories.show', $grandchild->slug) }}"
                                                                    class="flex items-center justify-between px-3 py-1.5 rounded-lg hover:bg-white hover:shadow-sm transition-all duration-150 group/subitem">
                                                                    <div class="flex items-center space-x-2 min-w-0 flex-1">
                                                                        {{-- File Icon for leaf categories --}}
                                                                        <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0 group-hover/subitem:text-primary"
                                                                            fill="currentColor" viewBox="0 0 24 24">
                                                                            <path
                                                                                d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                                                                        </svg>
                                                                        <span
                                                                            class="text-xs text-gray-500 group-hover/subitem:text-primary truncate">
                                                                            {{ $grandchild->name }}
                                                                        </span>
                                                                    </div>
                                                                    {{-- Grandchild product count --}}
                                                                    @if (($grandchild->products_count ?? 0) > 0)
                                                                        <span
                                                                            class="text-xs text-gray-400 bg-gray-50 px-2 py-0.5 rounded flex-shrink-0 ml-2">
                                                                            {{ $grandchild->products_count }}
                                                                        </span>
                                                                    @endif
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-16 bg-white rounded-lg border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Categories</h3>
                        <p class="text-gray-600 mb-6">There are no categories available at the moment.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors">
                            Browse All Products
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
