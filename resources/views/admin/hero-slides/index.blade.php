@extends('admin.layouts.app')

@section('title', 'Hero Slides')
@section('page-title', 'Hero Slides Management')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Hero Slides</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Hero Slides</h1>
                        <p class="text-gray-600 mt-1">Manage hero banner slides for your homepage</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.hero-slides.create') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Slide
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Slides</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $slides->total() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Active Slides</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $activeSlides }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Images</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $slides->where('type', 'image')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Videos</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $slides->where('type', 'video')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slides Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Preview
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Content
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Position
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Order
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="sortable" class="bg-white divide-y divide-gray-200">
                            @forelse($slides as $slide)
                                <tr data-id="{{ $slide->id }}" class="hover:bg-gray-50/80 transition-colors cursor-move">
                                    <td class="px-6 py-4">
                                        <div
                                            class="h-24 w-40 rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                                            @if ($slide->type === 'image')
                                                <img src="{{ asset('storage/' . $slide->background) }}"
                                                    alt="Slide Preview" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gray-800">
                                                    <svg class="h-12 w-12 text-white" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $slide->title_en }}</span>
                                                @if ($slide->badge_en)
                                                    <span
                                                        class="ml-2 px-2 py-0.5 text-xs bg-primary/10 text-primary rounded-full">
                                                        {{ $slide->badge_en }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if ($slide->subtitle_en)
                                                <p class="text-sm text-gray-600 line-clamp-2">
                                                    {{ Str::limit($slide->subtitle_en, 100) }}</p>
                                            @endif
                                            @if ($slide->has_cta && !empty($slide->cta_buttons))
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    @php
                                                        // Decode CTA buttons if they're stored as JSON
                                                        $ctaButtons = $slide->cta_buttons;
                                                        if (is_string($ctaButtons)) {
                                                            $ctaButtons = json_decode($ctaButtons, true);
                                                        }
                                                    @endphp
                                                    @if (is_array($ctaButtons) && count($ctaButtons) > 0)
                                                        @foreach ($ctaButtons as $button)
                                                            @if (isset($button['label_en']))
                                                                <span
                                                                    class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                                                    {{ $button['label_en'] }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $slide->type === 'image' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ ucfirst($slide->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 capitalize">
                                            {{ $slide->content_position }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="toggleStatus(this, {{ $slide->id }})"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 {{ $slide->is_active ? 'bg-primary' : 'bg-gray-200' }}">
                                            <span
                                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $slide->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="moveOrder(this, {{ $slide->id }}, 'up')"
                                                {{ $loop->first ? 'disabled' : '' }}
                                                class="p-1 text-gray-400 hover:text-gray-600 {{ $loop->first ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                </svg>
                                            </button>
                                            <span class="text-sm text-gray-900">{{ $slide->sort_order }}</span>
                                            <button onclick="moveOrder(this, {{ $slide->id }}, 'down')"
                                                {{ $loop->last ? 'disabled' : '' }}
                                                class="p-1 text-gray-400 hover:text-gray-600 {{ $loop->last ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.hero-slides.edit', $slide) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-sm font-medium transition-colors">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <button
                                                onclick="deleteSlide({{ $slide->id }}, '{{ addslashes($slide->title_en) }}')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-sm font-medium transition-colors">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="h-16 w-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No slides found</h3>
                                            <p class="text-gray-600 mb-6">Get started by creating your first hero slide</p>
                                            <a href="{{ route('admin.hero-slides.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Create Slide
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($slides->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $slides->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden z-50">
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-2xl bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">
                                    Delete Slide
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete "<span id="slideTitle"
                                            class="font-medium"></span>"?
                                        This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <form id="deleteForm" method="POST" class="inline" data-form>
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-loading data-loading-text="Deleting..."
                                    class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                    Delete
                                </button>
                            </form>
                            <button type="button" onclick="closeDeleteModal()"
                                class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        const csrfToken = '{{ csrf_token() }}';

        /* ---------- DRAG & DROP REORDER ---------- */
        @if ($slides->count() > 0)
            const sortable = new Sortable(document.getElementById('sortable'), {
                animation: 150,
                handle: 'tr',
                onEnd: function(evt) {
                    const slides = [];
                    document.querySelectorAll('#sortable tr').forEach((row, index) => {
                        slides.push({
                            id: row.dataset.id,
                            sort_order: index + 1
                        });
                    });

                    saveNewOrder(slides);
                }
            });
        @endif

        function saveNewOrder(slides) {
            fetch('{{ route('admin.hero-slides.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        slides: slides
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        flash('Order updated successfully!', 'success', 3000);
                    }
                })
                .catch(error => {
                    flash('Failed to update order', 'error', 5000);
                    console.error(error);
                });
        }

        /* ---------- SINGLE DELETE ---------- */
        function deleteSlide(id, title) {
            document.getElementById('slideTitle').textContent = title;
            document.getElementById('deleteForm').action = `/admin/hero-slides/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        /* ---------- STATUS TOGGLE ---------- */
        function toggleStatus(button, id) {
            if (button.dataset.loading === '1') return;

            button.dataset.loading = '1';
            button.classList.add('opacity-60', 'cursor-not-allowed');

            fetch(`/admin/hero-slides/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // UI Update logic
                        button.classList.toggle('bg-primary', data.is_active);
                        button.classList.toggle('bg-gray-200', !data.is_active);

                        const knob = button.querySelector('span');
                        knob.classList.toggle('translate-x-5', data.is_active);
                        knob.classList.toggle('translate-x-0', !data.is_active);

                        // Flash success message
                        flash(data.message || 'Status updated!', 'success', 3000);
                    } else {
                        flash(data.message || 'Update failed', 'error', 5000);
                    }
                })
                .finally(() => {
                    button.dataset.loading = '0';
                    button.classList.remove('opacity-60', 'cursor-not-allowed');
                });
        }

        /* ---------- ORDER BUTTONS ---------- */
        function moveOrder(button, id, direction) {
            if (button.dataset.loading === '1') return;

            button.dataset.loading = '1';
            button.classList.add('opacity-60', 'cursor-not-allowed');

            // Find current row
            const row = button.closest('tr');
            const currentOrder = parseInt(row.querySelector('td:nth-child(6) span').textContent);

            // Collect all slides
            const slides = [];
            document.querySelectorAll('#sortable tr').forEach((row, index) => {
                const slideId = row.dataset.id;
                const orderSpan = row.querySelector('td:nth-child(6) span');
                const order = parseInt(orderSpan.textContent);
                slides.push({
                    id: slideId,
                    sort_order: order
                });
            });

            // Find the slide to swap with
            const currentIndex = slides.findIndex(s => s.id == id);
            let targetIndex = direction === 'up' ? currentIndex - 1 : currentIndex + 1;

            if (targetIndex >= 0 && targetIndex < slides.length) {
                // Swap orders
                [slides[currentIndex].sort_order, slides[targetIndex].sort_order] = [slides[targetIndex].sort_order, slides[
                    currentIndex].sort_order];

                saveNewOrder(slides);
                setTimeout(() => location.reload(), 300);
            }

            button.dataset.loading = '0';
            button.classList.remove('opacity-60', 'cursor-not-allowed');
        }

        /* ---------- MODAL HANDLING ---------- */
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target.id === 'deleteModal') {
                closeDeleteModal();
            }
        });
    </script>
@endpush
