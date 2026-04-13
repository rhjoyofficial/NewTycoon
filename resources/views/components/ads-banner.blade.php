{{-- resources/views/components/ads-banner.blade.php --}}
@props(['banner'])

@php
    $slides = collect($banner->slides);
    $count = $slides->count();

    $gridClass = match ($count) {
        1 => 'grid-cols-1',
        2 => 'grid-cols-2',
        default => 'grid-cols-3',
    };

    // aspect ratio decision
    $aspectRatio = $count === 1 ? 'aspect-[28/5]' : 'aspect-[16/6]';
@endphp

@if ($count > 0)

    <section class="max-w-8xl mx-auto px-4">

        <div class="grid {{ $gridClass }} gap-4">

            @foreach ($slides as $slide)
                <a href="{{ $banner->link ?? '#' }}" class="group block w-full">

                    <div
                        class=" relative {{ $aspectRatio }} w-full overflow-hidden bg-gray-100 transition-all duration-300 group-hover:scale-[1.02] group-hover:shadow-lg ">

                        <img src="{{ $slide }}" loading="lazy" alt="Advertisement Banner"
                            class="absolute inset-0 w-full h-full object-cover " />

                    </div>

                </a>
            @endforeach

        </div>

    </section>

@endif
