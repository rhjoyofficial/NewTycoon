@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Category Management')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Categories</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
                        <p class="text-gray-600 mt-1">Manage product categories and subcategories</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.categories.create') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Category
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
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Categories</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalCategories }}</p>
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
                                <p class="text-sm font-medium text-gray-600">Active Categories</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $activeCategories }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Featured</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $featuredCategories }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Products</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters & Bulk Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" placeholder="Search categories..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex items-center space-x-3">
                        <select id="statusFilter"
                            class="border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <select id="parentFilter"
                            class="border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            <option value="">All Parents</option>
                            <option value="root">Root Categories</option>
                            @foreach ($rootCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="flex items-center space-x-3">
                        <select id="bulkAction"
                            class="border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            <option value="">Bulk Actions</option>
                            <option value="activate">Activate Selected</option>
                            <option value="deactivate">Deactivate Selected</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                        <button id="applyBulkAction"
                            class="px-4 py-2.5 bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col"
                                    class="pl-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <input type="checkbox" id="selectAll"
                                        class="rounded border-gray-300 text-primary focus:ring-primary">
                                </th>
                                <th scope="col"
                                    class="pl-3 pr-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Category
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Parent
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Products
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Featured
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
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($categories as $category)
                                {{-- Level 1: Root Categories --}}
                                @include('admin.categories.partials.category-row', [
                                    'category' => $category,
                                    'level' => 1,
                                ])

                                {{-- Level 2: Children --}}
                                @foreach ($category->children as $child)
                                    @include('admin.categories.partials.category-row', [
                                        'category' => $child,
                                        'level' => 2,
                                        'parent' => $category,
                                    ])

                                    {{-- Level 3: Grandchildren --}}
                                    @foreach ($child->children as $grandchild)
                                        @include('admin.categories.partials.category-row', [
                                            'category' => $grandchild,
                                            'level' => 3,
                                            'parent' => $child,
                                        ])
                                    @endforeach
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No categories yet</h3>
                                            <p class="text-gray-600 mb-6">Get started by creating your first category</p>
                                            <a href="{{ route('admin.categories.create') }}"
                                                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Create Category
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($categories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $categories->links() }}
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
                                    Delete Category
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete "<span id="categoryName"
                                            class="font-medium"></span>"?
                                        This action cannot be undone. All products in this category will be moved to
                                        "Uncategorized".
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <form id="deleteForm" method="POST" data-form
                                data-base-action="{{ route('admin.categories.destroy', ':id') }}">
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

@push('scripts')
    <script>
        const csrfToken = '{{ csrf_token() }}';

        /* ---------- SELECT ALL CHECKBOX ---------- */
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        /* ---------- BULK ACTIONS ---------- */
        document.getElementById('applyBulkAction').addEventListener('click', function() {
            const action = document.getElementById('bulkAction').value;
            const selectedIds = Array.from(document.querySelectorAll('.category-checkbox:checked'))
                .map(cb => cb.value);

            if (!action || selectedIds.length === 0) {
                flash('Please select an action and categories', 'error', 5000);
                return;
            }

            let endpoint, confirmMsg;

            switch (action) {
                case 'activate':
                    endpoint = '/admin/categories/bulk/activate';
                    confirmMsg = `Activate ${selectedIds.length} category(ies)?`;
                    break;
                case 'deactivate':
                    endpoint = '/admin/categories/bulk/deactivate';
                    confirmMsg = `Deactivate ${selectedIds.length} category(ies)?`;
                    break;
                case 'delete':
                    endpoint = '/admin/categories/bulk/delete';
                    confirmMsg = `Delete ${selectedIds.length} category(ies)? This action cannot be undone.`;
                    break;
                default:
                    return;
            }

            if (confirm(confirmMsg)) {
                fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ids: selectedIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            flash(data.message, 'success', 5000);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            flash(data.message, 'error', 5000);
                        }
                    })
                    .catch(error => {
                        flash('An error occurred', 'error', 5000);
                        console.error(error);
                    });
            }
        });

        /* ---------- FILTERS ---------- */
        document.getElementById('statusFilter').addEventListener('change', function() {
            filterTable();
        });

        document.getElementById('parentFilter').addEventListener('change', function() {
            filterTable();
        });

        function filterTable() {
            const statusFilter = document.getElementById('statusFilter').value;
            const parentFilter = document.getElementById('parentFilter').value;

            // This is a simple frontend filter. For production, you may want to implement server-side filtering
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                let show = true;

                // Status filter
                if (statusFilter) {
                    const statusSelect = row.querySelector('select');
                    if (statusSelect) {
                        const isActive = statusSelect.value === '1';
                        const shouldBeActive = statusFilter === 'active';
                        if (isActive !== shouldBeActive) {
                            show = false;
                        }
                    }
                }

                // Parent filter
                if (parentFilter) {
                    const parentCell = row.querySelector('td:nth-child(3)');
                    if (parentCell) {
                        const parentText = parentCell.textContent.trim();
                        if (parentFilter === 'root') {
                            if (!parentText.includes('Root')) {
                                show = false;
                            }
                        } else {
                            // You'll need to add data-parent-id attribute to rows for proper filtering
                        }
                    }
                }

                row.style.display = show ? '' : 'none';
            });
        }

        /* ---------- SINGLE DELETE ---------- */
        function openDeleteModal(button) {
            const id = button.dataset.id;
            const name = button.dataset.name;

            const form = document.getElementById('deleteForm');
            const baseAction = form.dataset.baseAction;

            form.action = baseAction.replace(':id', id);
            document.getElementById('categoryName').textContent = name;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        /* ---------- FEATURE TOGGLE ---------- */
        function toggleFeatured(button, id) {
            if (button.dataset.loading === '1') return;

            button.dataset.loading = '1';
            button.classList.add('opacity-60', 'cursor-not-allowed');

            fetch(`/admin/categories/${id}/toggle-feature`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Button background
                        button.classList.toggle('bg-primary', data.is_featured);
                        button.classList.toggle('bg-gray-300', !data.is_featured);

                        // Knob movement
                        const knob = button.querySelector('span');
                        knob.classList.toggle('translate-x-6', data.is_featured);
                        knob.classList.toggle('translate-x-1', !data.is_featured);

                        // Flash success message
                        flash(data.message || 'Featured status updated!', 'success', 3000);
                    } else {
                        // Handle logic failure from server
                        flash(data.message || 'Failed to update featured status.', 'error', 5000);
                    }
                })
                .finally(() => {
                    button.dataset.loading = '0';
                    button.classList.remove('opacity-60', 'cursor-not-allowed');
                });
        }


        /* ---------- STATUS CHANGE ---------- */
        function changeStatus(select, id) {
            if (select.dataset.loading === '1') return;

            select.dataset.loading = '1';
            select.disabled = true;

            fetch(`/admin/categories/${id}/change-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        is_active: select.value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (data.is_active) {
                            select.classList.add('border-green-300', 'bg-green-50', 'text-green-700');
                            select.classList.remove('border-red-300', 'bg-red-50', 'text-red-700');
                        } else {
                            select.classList.add('border-red-300', 'bg-red-50', 'text-red-700');
                            select.classList.remove('border-green-300', 'bg-green-50', 'text-green-700');
                        }
                        flash(data.message || 'Status updated successfully!', 'success', 3000);
                    } else {
                        flash(data.message || 'Failed to update status', 'error', 5000);
                        return;
                    }
                }).catch(err => {
                    // Network/Server crash
                    flash('A network error occurred.', 'error', 5000);
                    console.error(err);
                })
                .finally(() => {
                    select.dataset.loading = '0';
                    select.disabled = false;
                });
        }


        /* ---------- ORDER CHANGE ---------- */
        function moveOrder(button, id, direction) {
            if (button.dataset.loading === '1') return;

            button.dataset.loading = '1';
            button.classList.add('opacity-60', 'cursor-not-allowed');

            fetch(`/admin/categories/${id}/reorder`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        direction: direction
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        setTimeout(() => location.reload(), 300);
                    }
                })
                .finally(() => {
                    button.dataset.loading = '0';
                    button.classList.remove('opacity-60', 'cursor-not-allowed');
                });
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
