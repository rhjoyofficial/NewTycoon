@extends('admin.layouts.app')

@section('title', 'Catalogs')
@section('page-title', 'Catalogs')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Catalogs</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Manage Catalogs</h1>
            <button onclick="openCreateModal()"
                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                <i class="fas fa-plus mr-2"></i>Add New Catalog
            </button>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" id="flash-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thumbnail
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PDF</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($catalogs as $catalog)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $catalog->sort_order ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($catalog->thumbnail_url)
                                    <img src="{{ $catalog->thumbnail_url }}" class="h-10 w-10 object-cover rounded"
                                        loading="lazy">
                                @else
                                    <div class="h-10 w-10 bg-gray-100 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $catalog->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $catalog->company_name ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($catalog->pdf_file)
                                    <a href="{{ $catalog->pdf_url }}" target="_blank"
                                        class="inline-flex items-center text-xs text-red-600 hover:text-red-800 font-medium">
                                        <i class="fas fa-file-pdf mr-1"></i> View PDF
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">No file</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- Click to toggle status --}}
                                <button
                                    onclick="toggleStatus({{ $catalog->id }}, {{ $catalog->is_active ? 'true' : 'false' }}, this)"
                                    title="Click to toggle"
                                    class="px-2 py-1 text-xs rounded-full cursor-pointer transition-all focus:outline-none
                                        {{ $catalog->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    {{ $catalog->is_active ? 'Active' : 'Inactive' }}
                                </button>
                                {{-- Hidden toggle form --}}
                                <form id="toggle-form-{{ $catalog->id }}"
                                    action="{{ route('admin.content.catalogs.toggle', $catalog) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button
                                    onclick="openEditModal(
                                        {{ $catalog->id }},
                                        '{{ addslashes($catalog->title) }}',
                                        '{{ addslashes($catalog->company_name ?? '') }}',
                                        '{{ addslashes($catalog->description ?? '') }}',
                                        {{ $catalog->is_active ? 'true' : 'false' }},
                                        {{ $catalog->sort_order ?? 0 }},
                                        '{{ $catalog->thumbnail_url ?? '' }}'
                                    )"
                                    class="text-primary hover:text-primary/80">Edit</button>
                                <button
                                    onclick="openDeleteModal({{ $catalog->id }}, '{{ addslashes($catalog->title) }}')"
                                    class="text-red-600 hover:text-red-800">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No catalogs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($catalogs->hasPages())
            <div class="mt-4">
                {{ $catalogs->links() }}
            </div>
        @endif
    </div>

    {{-- ===================== CREATE MODAL ===================== --}}
    <div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeCreateModal()"></div>

            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg z-10 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-gray-900">Add New Catalog</h2>
                    <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.content.catalogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40"
                                placeholder="Catalog title">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                            <input type="text" name="company_name"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40"
                                placeholder="Company name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40"
                                placeholder="Brief description..."></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">PDF File <span
                                        class="text-red-500">*</span></label>
                                <input type="file" name="pdf_file" accept=".pdf" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                                <p class="text-xs text-gray-400 mt-1">Max 20MB</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                                <input type="file" name="thumbnail" accept="image/*"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                                <input type="number" name="sort_order" value="0" min="0"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                            </div>
                            <div class="flex items-end pb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked
                                        class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="text-sm font-medium text-gray-700">Active</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeCreateModal()"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-primary hover:bg-primary/90 rounded-lg transition-colors">
                            <i class="fas fa-save mr-1"></i> Save Catalog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== EDIT MODAL ===================== --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeEditModal()"></div>

            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg z-10 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-gray-900">Edit Catalog</h2>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" id="editTitle" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                            <input type="text" name="company_name" id="editCompanyName"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="editDescription" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Replace PDF</label>
                                <input type="file" name="pdf_file" accept=".pdf"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                                <p class="text-xs text-gray-400 mt-1">Leave blank to keep current</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Replace Thumbnail</label>
                                <div id="editThumbnailPreview" class="mb-1 hidden">
                                    <img id="editThumbnailImg" src="" class="h-10 w-10 object-cover rounded">
                                </div>
                                <input type="file" name="thumbnail" accept="image/*"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                                <input type="number" name="sort_order" id="editSortOrder" min="0"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                            </div>
                            <div class="flex items-end pb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="editIsActive" value="1"
                                        class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="text-sm font-medium text-gray-700">Active</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-primary hover:bg-primary/90 rounded-lg transition-colors">
                            <i class="fas fa-save mr-1"></i> Update Catalog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== DELETE MODAL ===================== --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeDeleteModal()"></div>

            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md z-10 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">Delete Catalog</h2>
                    <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="flex items-start gap-4 mb-6">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Are you sure you want to delete</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1" id="deleteCatalogName"></p>
                        <p class="text-xs text-gray-400 mt-1">This will also delete the PDF and thumbnail. This action
                            cannot be undone.</p>
                    </div>
                </div>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                            <i class="fas fa-trash mr-1"></i> Yes, Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== SCRIPTS ===================== --}}
    <script>
        // ─── Create Modal ─────────────────────────────────────
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // ─── Edit Modal ───────────────────────────────────────
        function openEditModal(id, title, companyName, description, isActive, sortOrder, thumbnailUrl) {
            const baseUrl = "{{ url('admin/content/catalogs') }}";
            document.getElementById('editForm').action = baseUrl + '/' + id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editCompanyName').value = companyName;
            document.getElementById('editDescription').value = description;
            document.getElementById('editSortOrder').value = sortOrder;
            document.getElementById('editIsActive').checked = isActive;

            const preview = document.getElementById('editThumbnailPreview');
            const img = document.getElementById('editThumbnailImg');
            if (thumbnailUrl) {
                img.src = thumbnailUrl;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }

            document.getElementById('editModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // ─── Delete Modal ─────────────────────────────────────
        function openDeleteModal(id, title) {
            const baseUrl = "{{ url('admin/content/catalogs') }}";
            document.getElementById('deleteForm').action = baseUrl + '/' + id;
            document.getElementById('deleteCatalogName').textContent = '"' + title + '"';
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // ─── Status Toggle ────────────────────────────────────
        function toggleStatus(id, currentStatus, btn) {
            if (!confirm('Toggle status for this catalog?')) return;
            document.getElementById('toggle-form-' + id).submit();
        }

        // ─── Close modals on Escape key ──────────────────────
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeEditModal();
                closeDeleteModal();
            }
        });

        // ─── Auto-hide flash message ──────────────────────────
        const flash = document.getElementById('flash-message');
        if (flash) {
            setTimeout(() => flash.style.display = 'none', 4000);
        }
    </script>
@endsection
