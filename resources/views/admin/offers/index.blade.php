@extends('admin.layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Offers Management</h1>
                        <p class="mt-2 text-sm text-gray-600">Manage promotional offers and their settings</p>
                    </div>
                    <a href="{{ route('admin.offers.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create New Offer
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-50 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Offers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $offers->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-50 rounded-xl">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Active</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-50 rounded-xl">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Scheduled</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $scheduledCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-50 rounded-xl">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Views</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalViews ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offers Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-900">All Offers</h2>
                    <p class="text-sm text-gray-600 mt-1">Drag handles to reorder offers</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span class="text-gray-400 mr-2">⤵</span>
                                        Order
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title & Details
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Products
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Performance
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="sortable-offers">
                            @forelse($offers as $offer)
                                <tr data-id="{{ $offer->id }}" class="hover:bg-gray-50 transition-colors">
                                    <!-- Order -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-3 cursor-move handle" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 8h16M4 16h16" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900">{{ $offer->order }}</span>
                                        </div>
                                    </td>

                                    <!-- Title & Details -->
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="flex items-center">
                                                <h3 class="text-sm font-semibold text-gray-900">{{ $offer->title }}</h3>
                                                @if ($offer->is_active)
                                                    <span
                                                        class="ml-2 px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">Live</span>
                                                @endif
                                            </div>
                                            @if ($offer->subtitle)
                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ Str::limit($offer->subtitle, 60) }}</p>
                                            @endif
                                            <div class="mt-2 flex items-center text-xs text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                @if ($offer->start_date && $offer->end_date)
                                                    {{ $offer->start_date->format('M d') }} -
                                                    {{ $offer->end_date->format('M d, Y') }}
                                                @else
                                                    No schedule
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $offer->status === 'active'
                                                ? 'bg-green-100 text-green-800'
                                                : ($offer->status === 'draft'
                                                    ? 'bg-gray-100 text-gray-800'
                                                    : ($offer->status === 'scheduled'
                                                        ? 'bg-blue-100 text-blue-800'
                                                        : 'bg-yellow-100 text-yellow-800')) }}">
                                                {{ ucfirst($offer->status) }}
                                            </span>
                                            @if ($offer->timer_enabled && $offer->timer_end_date)
                                                <div class="flex items-center text-xs text-yellow-600">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Ends: {{ $offer->timer_end_date->format('M d') }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Products -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center mr-3">
                                                <span
                                                    class="text-sm font-semibold text-primary">{{ $offer->products_count }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ ucfirst($offer->product_source) }}</span>
                                                <p class="text-xs text-gray-500">Source</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Performance -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Views:</span>
                                                <span
                                                    class="font-medium text-gray-900">{{ number_format($offer->view_count) }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Clicks:</span>
                                                <span
                                                    class="font-medium text-gray-900">{{ number_format($offer->click_count) }}</span>
                                            </div>
                                            @if ($offer->view_count > 0)
                                                <div class="text-xs text-gray-500 text-right">
                                                    {{ round(($offer->click_count / $offer->view_count) * 100, 1) }}% CTR
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <!-- Edit -->
                                            <a href="{{ route('admin.offers.edit', $offer) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-primary text-primary rounded-lg hover:bg-primary/5 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary transition-colors"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Toggle Status -->
                                            <form action="{{ route('admin.offers.toggle-status', $offer) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border {{ $offer->is_active ? 'border-green-300 text-green-700' : 'border-yellow-300 text-yellow-700' }} rounded-lg hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-yellow-500 transition-colors"
                                                    title="{{ $offer->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this offer?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-500 transition-colors"
                                                    title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="text-gray-400">
                                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">No offers found</h3>
                                            <p class="text-gray-600">Create your first offer to get started</p>
                                            <a href="{{ route('admin.offers.create') }}"
                                                class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                                                Create Offer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($offers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $offers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('sortable-offers');
            if (tbody) {
                new Sortable(tbody, {
                    handle: '.handle',
                    animation: 150,
                    ghostClass: 'bg-blue-50',
                    chosenClass: 'bg-blue-100',
                    dragClass: 'opacity-50',
                    onEnd: function() {
                        const offers = [];
                        document.querySelectorAll('#sortable-offers tr[data-id]').forEach((row,
                            index) => {
                            offers.push({
                                id: row.dataset.id,
                                order: index + 1
                            });
                        });

                        fetch('{{ route('admin.offers.reorder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                offers
                            })
                        }).then(response => {
                            if (response.ok) {
                                // Update order numbers visually
                                document.querySelectorAll('#sortable-offers tr[data-id]')
                                    .forEach((row, index) => {
                                        const orderSpan = row.querySelector(
                                            '.text-gray-900.font-medium');
                                        if (orderSpan) {
                                            orderSpan.textContent = index + 1;
                                        }
                                    });

                                // Show success message
                                const successDiv = document.createElement('div');
                                successDiv.className =
                                    'fixed top-4 right-4 p-4 bg-green-50 border border-green-200 rounded-xl shadow-lg z-50';
                                successDiv.innerHTML = `
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-green-800">Order updated successfully</span>
                            </div>
                        `;
                                document.body.appendChild(successDiv);

                                setTimeout(() => {
                                    successDiv.remove();
                                }, 3000);
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
