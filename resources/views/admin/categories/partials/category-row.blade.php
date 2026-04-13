@php
    $indentation = ['', 'pl-8', 'pl-12'][$level - 1] ?? '';
    $imageSize = ['w-10 h-10', 'w-9 h-9', 'w-8 h-8'][$level - 1] ?? 'w-7 h-7';
@endphp

<tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
    {{-- Checkbox --}}
    <td class="px-4 py-3">
        <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}"
            class="category-checkbox w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/30">
    </td>

    {{-- Category Name --}}
    <td class="px-4 py-3">
        <div class="flex items-start {{ $indentation }}">
            @if ($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name_en }}"
                    class="{{ $imageSize }} rounded-lg object-cover border border-gray-200 mr-3">
            @else
                <div
                    class="{{ $imageSize }} rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            @endif
            <div>
                <div class="flex items-center gap-1">
                    @if ($level > 1)
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @endif
                    <span class="text-sm font-medium text-gray-900">{{ $category->name_en }}</span>
                </div>
                @if ($category->name_bn)
                    <div class="text-xs text-gray-600 font-bengali mt-0.5">{{ $category->name_bn }}</div>
                @endif
            </div>
        </div>
    </td>

    {{-- Parent --}}
    <td class="px-4 py-3">
        @if ($level === 1)
            <span class="text-xs text-gray-500 italic">Root</span>
        @else
            <div class="text-sm text-gray-700">{{ $parent->name_en }}</div>
            @if ($parent->name_bn)
                <div class="text-xs text-gray-500 font-bengali">{{ $parent->name_bn }}</div>
            @endif
        @endif
    </td>

    {{-- Products Count --}}
    <td class="px-4 py-3">
        <div class="text-center">
            @if ($level === 3)
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                    {{ $category->products_count ?? 0 }}
                </span>
            @else
                <span class="text-xs text-gray-500">N/A</span>
            @endif
        </div>
    </td>

    {{-- Status --}}
    <td class="px-4 py-3">
        <select onchange="changeStatus(this, {{ $category->id }})"
            class="text-sm px-3 py-1.5 rounded-lg border focus:ring-1 focus:ring-primary/30 focus:border-primary/50 transition-colors w-full max-w-[120px]
            {{ $category->is_active ? 'border-green-300 bg-green-50 text-green-700' : 'border-red-300 bg-red-50 text-red-700' }}">
            <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
        </select>
    </td>

    {{-- Featured Toggle --}}
    <td class="px-4 py-3">
        <div class="flex justify-center">
            @if ($level === 1 || $level === 2)
                {{-- Featured Toggle --}}
                <button onclick="toggleFeatured(this, {{ $category->id }})"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors cursor-pointer
                {{ $category->is_featured ? 'bg-primary' : 'bg-gray-300' }}">
                    <span
                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform
                    {{ $category->is_featured ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
            @else
                <span class="text-xs text-gray-500">N/A</span>
            @endif
        </div>
    </td>


    {{-- Order --}}
    <td class="px-4 py-3">
        <div class="flex items-center justify-center gap-2">
            <button onclick="moveOrder(this, {{ $category->id }}, 'up')"
                class="p-1 text-gray-500 hover:text-primary hover:bg-gray-100 rounded transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            <span class="text-sm font-medium text-gray-700 w-8 text-center">{{ $category->order }}</span>
            <button onclick="moveOrder(this, {{ $category->id }}, 'down')"
                class="p-1 text-gray-500 hover:text-primary hover:bg-gray-100 rounded transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
    </td>

    {{-- Actions --}}
    <td class="px-4 py-3">
        <div class="flex items-center gap-1">
            <a href="{{ route('admin.categories.edit', $category) }}"
                class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-primary-light text-gray-700 hover:text-primary rounded-lg text-xs font-medium transition-colors border border-gray-200 hover:border-primary/30">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <button data-id="{{ $category->id }}" data-name="{{ e($category->name_en) }}"
                onclick="openDeleteModal(this)"
                class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-600 rounded-lg text-xs font-medium transition-colors border border-gray-200 hover:border-red-300">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete
            </button>
        </div>
    </td>
</tr>
