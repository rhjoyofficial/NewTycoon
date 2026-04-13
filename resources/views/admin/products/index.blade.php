@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Product Management')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Products</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Filters and Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">All Products</h2>
                        <p class="text-sm text-gray-600">Manage your store products</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.products.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary/90 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Product
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <form method="GET" class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                            <option value="all">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                            <option value="all">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name_en }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
                        <select name="stock_status"
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                            <option value="all">All Stock</option>
                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock
                            </option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                                Out
                                of Stock</option>
                            <option value="backorder" {{ request('stock_status') == 'backorder' ? 'selected' : '' }}>
                                Backorder
                            </option>
                        </select>
                    </div>

                    <div class="md:col-span-4 flex justify-end space-x-3">
                        <button type="submit"
                            class="px-4 py-2 bg-primary hover:bg-primary/90 text-white font-medium rounded-lg transition-colors">
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.products.index') }}"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hidden" id="bulkActions">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600" id="selectedCount">0 products selected</span>
                    <div class="flex items-center space-x-3">
                        <select id="bulkAction" class="rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                            <option value="">Bulk Actions</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="archive">Archive</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button onclick="applyBulkAction()"
                            class="px-4 py-2 bg-primary hover:bg-primary/90 text-white font-medium rounded-lg transition-colors">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="pl-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="selectAll"
                                        class="rounded border-gray-300 text-primary focus:ring-primary">
                                </th>
                                <th
                                    class="pl-3 pr-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SKU
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="pl-4 py-4 whitespace-nowrap">
                                        <input type="checkbox" value="{{ $product->id }}"
                                            class="product-checkbox rounded border-gray-300 text-primary focus:ring-primary">
                                    </td>
                                    <td class="pl-3 pr-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <img class="h-10 w-10 rounded-lg object-cover"
                                                    src="{{ $product->featured_image_url }}"
                                                    alt="{{ $product->name_en }}">
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('admin.products.show', $product) }}">
                                                    <div class="text-sm font-medium text-gray-900"
                                                        title="{{ $product->name_en }}">
                                                        {{ $product->name_en }}
                                                    </div>
                                                </a>
                                                <div class="text-sm text-gray-500 truncate max-w-xs"
                                                    title="{{ $product->short_description }}">
                                                    {{ $product->short_description }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->sku }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->category->name_en ?? 'Uncategorized' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="font-medium text-gray-900">
                                            {{ format_currency($product->price) }}
                                        </div>
                                        @if ($product->compare_price > $product->price)
                                            <div class="text-sm text-gray-500 line-through">
                                                {{ format_currency($product->compare_price) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $product->quantity }}</div>
                                        <div class="text-xs">
                                            @if ($product->stock_status == 'in_stock')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    In Stock
                                                </span>
                                            @elseif($product->stock_status == 'out_of_stock')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Out of Stock
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Backorder
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select onchange="changeProductStatus(this, {{ $product->id }})"
                                            class="text-xs font-semibold px-2 py-1 rounded-full focus:ring-1 focus:ring-primary/30 focus:border-primary/50 transition-colors
                                            {{ $product->status == 'active'
                                                ? 'bg-green-100 text-green-800 border-green-300'
                                                : ($product->status == 'draft'
                                                    ? 'bg-gray-100 text-gray-800 border-gray-300'
                                                    : ($product->status == 'inactive'
                                                        ? 'bg-red-100 text-red-800 border-red-300'
                                                        : 'bg-yellow-100 text-yellow-800 border-yellow-300')) }}">
                                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>
                                                Draft</option>
                                            <option value="inactive"
                                                {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="archived"
                                                {{ $product->status == 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.products.show', $product->slug) }}"
                                                class="text-purple-600 hover:text-purple-900"
                                                title="View Analytics & Details">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('product.show', $product->slug) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900" title="View">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button
                                                onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name_en) }}')"
                                                class="text-red-600 hover:text-red-900" title="Delete">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900">No products found</p>
                                            <p class="text-gray-600 mt-1">Get started by creating your first product</p>
                                            <a href="{{ route('admin.products.create') }}"
                                                class="mt-4 inline-flex items-center px-4 py-2 bg-primary hover:bg-primary/90 text-white font-medium rounded-lg transition-colors">
                                                Add Product
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $products->withQueryString()->links() }}
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
                                    Delete Product
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete the product "<span id="productName"
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

@push('scripts')
    <script>
        const csrfToken = '{{ csrf_token() }}';
        /* ---------- SINGLE DELETE ---------- */
        function deleteProduct(id, name) {
            document.getElementById('productName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/products/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
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

        function changeProductStatus(select, id) {
            if (select.dataset.loading === '1') return;

            select.dataset.loading = '1';
            select.disabled = true;

            fetch(`/admin/products/${id}/change-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: select.value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Remove all possible status classes
                        select.classList.remove(
                            'bg-green-100', 'text-green-800', 'border-green-300',
                            'bg-gray-100', 'text-gray-800', 'border-gray-300',
                            'bg-red-100', 'text-red-800', 'border-red-300',
                            'bg-yellow-100', 'text-yellow-800', 'border-yellow-300'
                        );

                        // Map status to classes
                        const statusClasses = {
                            'active': ['bg-green-100', 'text-green-800', 'border-green-300'],
                            'draft': ['bg-gray-100', 'text-gray-800', 'border-gray-300'],
                            'inactive': ['bg-red-100', 'text-red-800', 'border-red-300'],
                            'archived': ['bg-yellow-100', 'text-yellow-800', 'border-yellow-300']
                        };

                        if (statusClasses[data.status]) {
                            select.classList.add(...statusClasses[data.status]);
                        }

                        flash(data.message || 'Product status updated!', 'success', 3000);
                    } else {
                        flash(data.message || 'Failed to update status', 'error', 5000);
                    }
                })
                .catch(err => {
                    flash('System error: Could not reach the server.', 'error', 5000);
                    console.error(err);
                })
                .finally(() => {
                    select.dataset.loading = '0';
                    select.disabled = false;
                });
        }


        // Bulk selection functionality
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            // Select all functionality
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateBulkActions();
            });

            // Individual checkbox functionality
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });

            function updateBulkActions() {
                const selected = document.querySelectorAll('.product-checkbox:checked');
                const count = selected.length;

                if (count > 0) {
                    bulkActions.classList.remove('hidden');
                    selectedCount.textContent = `${count} product${count > 1 ? 's' : ''} selected`;

                    // Update select all checkbox
                    selectAll.checked = count === checkboxes.length;
                    selectAll.indeterminate = count > 0 && count < checkboxes.length;
                } else {
                    bulkActions.classList.add('hidden');
                }
            }
        });

        function applyBulkAction() {
            const action = document.getElementById('bulkAction').value;
            const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (!action || selectedIds.length === 0) {
                alert('Please select an action and at least one product');
                return;
            }

            if (action === 'delete' && !confirm('Are you sure you want to delete the selected products?')) {
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.products.bulk-action') }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            form.appendChild(actionInput);

            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_ids[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endpush
