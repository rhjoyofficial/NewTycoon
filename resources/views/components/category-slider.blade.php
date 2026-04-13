<div class="w-full py-6 md:py-12 max-w-8xl mx-auto px-4 category-section">
    {{-- Category Grid --}}
    <div class="categories relative grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-1 md:gap-2 lg:gap-4">
        @if ($categories->isNotEmpty())
            @foreach ($categories as $item)
                <a href="{{ route('categories.show', $item->slug) }}"
                    class="group block category-tilt transition-all duration-500 hover:shadow-lg">
                    <div
                        class="relative bg-white rounded-xl p-0.5 shadow-sm flex flex-col md:h-40 overflow-hidden category-tilt-inner">
                        <!-- Animated Gradient Border -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-primary via-accent to-primary opacity-0 group-hover:opacity-100 transition-opacity duration-700 animate-gradient-x">
                        </div>

                        <!-- Card Content -->
                        <div class="relative flex flex-col h-full p-2 md:p-4 bg-white rounded-[10px] z-10">
                            <!-- Abstract Background Elements -->
                            <div class="absolute inset-0 overflow-hidden opacity-5">
                                <div class="absolute -top-4 -left-4 w-20 h-20 bg-primary rounded-full blur-md"></div>
                                <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-accent rounded-full blur-md">
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="flex-grow flex items-center justify-center relative">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="category-image h-12 md:h-24 object-contain transition-all duration-500 group-hover:scale-110 relative z-20">
                            </div>

                            <!-- Title -->
                            <div class="pt-2 md:pt-4 relative z-20" title="{{ $item->name }}">
                                <p
                                    class="text-sm md:text-base font-medium text-black text-center font-cambay line-clamp-1">
                                    {{ $item->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <p class="text-gray-500 col-span-full text-center">No featured categories found.</p>
        @endif
        {{-- <a href="{{ route('categories.index') }}"
            class="absolute bottom-0 right-0 rotate-90 origin-bottom-right group inline-flex items-center gap-1 text-gray-900 text-sm 2xl:text-base font-inter font-normal tracking-wide transition-colors duration-300 hover:text-primary">

            <span class="hover:underline">{{ __('home.cat-button') }}</span>

            <svg class="w-4 h-4 xl:w-5 xl:h-5 transition-all duration-300 group-hover:text-primary group-hover:-rotate-45"
                fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M26.68 3.867H8.175a1 1 0 0 0 0 2h16.544L4.2 26.387A1 1 0 1 0 5.613 27.8l20.52-20.52v16.545a1 1 0 0 0 2 0V5.321a1.456 1.456 0 0 0-1.453-1.454"
                    data-name="Layer 2" />
            </svg>
        </a> --}}
    </div>
</div>
