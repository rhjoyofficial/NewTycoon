@extends('admin.layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Page Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Footer Management</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage footer settings, columns, and links</p>
                </div>
            </div>

            {{-- ═══════════════════════ SETTINGS FORM ═══════════════════════ --}}
            <form action="{{ route('admin.footer.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-gray-900">Footer Settings</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Brand info, contact details, social links &amp; payment icons</p>
                    </div>

                    <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">

                        {{-- Brand --}}
                        <div class="space-y-5">
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Brand</h3>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name <span class="text-red-500">*</span></label>
                                <input type="text" name="brand_name" required
                                    value="{{ old('brand_name', $settings?->brand_name) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="e.g., Tycoon Hi-Tech Park">
                                @error('brand_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description (English)</label>
                                <textarea name="brand_description_en" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Short brand tagline or description">{{ old('brand_description_en', $settings?->brand_description_en) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description (বাংলা)</label>
                                <textarea name="brand_description_bn" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="বাংলা বিবরণ">{{ old('brand_description_bn', $settings?->brand_description_bn) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address (English)</label>
                                <input type="text" name="address_en"
                                    value="{{ old('address_en', $settings?->address_en) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Physical address">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address (বাংলা)</label>
                                <input type="text" name="address_bn"
                                    value="{{ old('address_bn', $settings?->address_bn) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="ঠিকানা বাংলায়">
                            </div>
                        </div>

                        {{-- Contact & Social --}}
                        <div class="space-y-5">
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Contact Info</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hotline 1</label>
                                    <input type="text" name="contact_info[hotline_1]"
                                        value="{{ old('contact_info.hotline_1', $settings?->contact_info['hotline_1'] ?? '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="+8801XXXXXXXXX">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hotline 2</label>
                                    <input type="text" name="contact_info[hotline_2]"
                                        value="{{ old('contact_info.hotline_2', $settings?->contact_info['hotline_2'] ?? '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="+8801XXXXXXXXX">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email 1</label>
                                    <input type="email" name="contact_info[email_1]"
                                        value="{{ old('contact_info.email_1', $settings?->contact_info['email_1'] ?? '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="info@example.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email 2</label>
                                    <input type="email" name="contact_info[email_2]"
                                        value="{{ old('contact_info.email_2', $settings?->contact_info['email_2'] ?? '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="support@example.com">
                                </div>
                            </div>

                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide pt-2">Social Links</h3>

                            @foreach (['facebook' => 'Facebook', 'twitter' => 'Twitter / X', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn'] as $key => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                                    <input type="text" name="social_links[{{ $key }}]"
                                        value="{{ old('social_links.' . $key, $settings?->social_links[$key] ?? '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="https://{{ $key }}.com/yourpage">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Payment Methods --}}
                    <div class="px-6 pb-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Payment Method Icons</h3>
                        <p class="text-xs text-gray-500 mb-3">Enter the asset path for each payment icon (e.g., <code>images/payment/visa.png</code>). One per line.</p>

                        <div id="payment-methods-list" class="space-y-2">
                            @php $payments = $settings?->payment_methods ?? ['']; @endphp
                            @foreach ($payments as $i => $pm)
                                <div class="flex gap-2 payment-row">
                                    <input type="text" name="payment_methods[]"
                                        value="{{ old('payment_methods.' . $i, $pm) }}"
                                        class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm"
                                        placeholder="images/payment/visa.png">
                                    <button type="button" onclick="removeRow(this)"
                                        class="px-3 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors text-sm">
                                        Remove
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" onclick="addPaymentRow()"
                            class="mt-3 px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors">
                            + Add Payment Icon
                        </button>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                        <button type="submit"
                            class="px-6 py-2.5 bg-primary text-white text-sm font-medium rounded-xl hover:bg-primary/90 transition-colors">
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>

            {{-- ═══════════════════════ COLUMNS & LINKS ═══════════════════════ --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Footer Columns</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Manage navigation columns and their links</p>
                    </div>
                    <button type="button" onclick="document.getElementById('add-column-modal').classList.remove('hidden')"
                        class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-xl hover:bg-primary/90 transition-colors">
                        + Add Column
                    </button>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($columns as $column)
                        <div class="p-6" id="column-{{ $column->id }}">
                            {{-- Column Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full {{ $column->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                    <div>
                                        <span class="font-semibold text-gray-900">{{ $column->title_en }}</span>
                                        @if ($column->title_bn)
                                            <span class="text-gray-400 text-sm ml-2">/ {{ $column->title_bn }}</span>
                                        @endif
                                        <span class="ml-2 text-xs text-gray-400">Order: {{ $column->sort_order }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        onclick="openEditColumnModal({{ $column->id }}, '{{ addslashes($column->title_en) }}', '{{ addslashes($column->title_bn ?? '') }}', {{ $column->sort_order }}, {{ $column->is_active ? 'true' : 'false' }})"
                                        class="px-3 py-1.5 text-xs bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.footer.columns.destroy', $column) }}" method="POST"
                                        onsubmit="return confirm('Delete this column and all its links?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Links List --}}
                            <div class="ml-5 space-y-2 mb-4">
                                @forelse ($column->links->sortBy('sort_order') as $link)
                                    <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <div class="w-1.5 h-1.5 rounded-full {{ $link->is_active ? 'bg-green-400' : 'bg-gray-300' }} flex-shrink-0"></div>
                                            <span class="text-sm text-gray-800">{{ $link->title_en }}</span>
                                            @if ($link->title_bn)
                                                <span class="text-xs text-gray-400">/ {{ $link->title_bn }}</span>
                                            @endif
                                            <span class="text-xs text-gray-400 truncate max-w-[200px]">— {{ $link->url }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <button type="button"
                                                onclick="openEditLinkModal({{ $link->id }}, '{{ addslashes($link->title_en) }}', '{{ addslashes($link->title_bn ?? '') }}', '{{ addslashes($link->url) }}', {{ $link->sort_order }}, {{ $link->is_active ? 'true' : 'false' }})"
                                                class="px-2 py-1 text-xs bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition-colors">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.footer.links.destroy', $link) }}" method="POST"
                                                onsubmit="return confirm('Delete this link?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="px-2 py-1 text-xs bg-red-50 text-red-700 rounded-md hover:bg-red-100 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 italic">No links yet.</p>
                                @endforelse
                            </div>

                            {{-- Add Link Button --}}
                            <button type="button"
                                onclick="openAddLinkModal({{ $column->id }})"
                                class="ml-5 px-3 py-1.5 text-xs bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                                + Add Link
                            </button>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-400">
                            <p class="text-sm">No columns yet. Click "Add Column" to get started.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════ MODALS ═══════════════════════ --}}

    {{-- Add Column Modal --}}
    <div id="add-column-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Add Column</h3>
                <button type="button" onclick="document.getElementById('add-column-modal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">&times;</button>
            </div>
            <form action="{{ route('admin.footer.columns.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="title_en" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                        placeholder="e.g., Quick Links">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title (বাংলা)</label>
                    <input type="text" name="title_bn"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                        placeholder="দ্রুত লিংক">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ $columns->count() + 1 }}" min="0"
                        class="w-32 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('add-column-modal').classList.add('hidden')"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-sm bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors">
                        Add Column
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Column Modal --}}
    <div id="edit-column-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Edit Column</h3>
                <button type="button" onclick="document.getElementById('edit-column-modal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">&times;</button>
            </div>
            <form id="edit-column-form" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title (English) <span class="text-red-500">*</span></label>
                    <input type="text" id="edit-column-title-en" name="title_en" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title (বাংলা)</label>
                    <input type="text" id="edit-column-title-bn" name="title_bn"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>
                <div class="flex gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" id="edit-column-sort" name="sort_order" min="0"
                            class="w-32 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                    </div>
                    <div class="flex items-end pb-0.5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="edit-column-active" name="is_active" value="1"
                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary/20">
                            <span class="text-sm font-medium text-gray-700">Active</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('edit-column-modal').classList.add('hidden')"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-sm bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors">
                        Update Column
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Link Modal --}}
    <div id="add-link-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Add Link</h3>
                <button type="button" onclick="document.getElementById('add-link-modal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">&times;</button>
            </div>
            <form id="add-link-form" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Text (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="title_en" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                        placeholder="e.g., About Us">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Text (বাংলা)</label>
                    <input type="text" name="title_bn"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                        placeholder="আমাদের সম্পর্কে">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL <span class="text-red-500">*</span></label>
                    <input type="text" name="url" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                        placeholder="/about or https://...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" min="0"
                        class="w-32 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('add-link-modal').classList.add('hidden')"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-sm bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors">
                        Add Link
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Link Modal --}}
    <div id="edit-link-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Edit Link</h3>
                <button type="button" onclick="document.getElementById('edit-link-modal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">&times;</button>
            </div>
            <form id="edit-link-form" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Text (English) <span class="text-red-500">*</span></label>
                    <input type="text" id="edit-link-title-en" name="title_en" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Text (বাংলা)</label>
                    <input type="text" id="edit-link-title-bn" name="title_bn"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL <span class="text-red-500">*</span></label>
                    <input type="text" id="edit-link-url" name="url" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>
                <div class="flex gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" id="edit-link-sort" name="sort_order" min="0"
                            class="w-32 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                    </div>
                    <div class="flex items-end pb-0.5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="edit-link-active" name="is_active" value="1"
                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary/20">
                            <span class="text-sm font-medium text-gray-700">Active</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('edit-link-modal').classList.add('hidden')"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-sm bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors">
                        Update Link
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Payment Methods
            function addPaymentRow() {
                const list = document.getElementById('payment-methods-list');
                const row = document.createElement('div');
                row.className = 'flex gap-2 payment-row';
                row.innerHTML = `
                    <input type="text" name="payment_methods[]"
                        class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm"
                        placeholder="images/payment/visa.png">
                    <button type="button" onclick="removeRow(this)"
                        class="px-3 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors text-sm">
                        Remove
                    </button>`;
                list.appendChild(row);
            }

            function removeRow(btn) {
                btn.closest('.payment-row').remove();
            }

            // Column Modals
            function openEditColumnModal(id, titleEn, titleBn, sort, isActive) {
                const baseUrl = '{{ url("admin/footer/columns") }}';
                document.getElementById('edit-column-form').action = `${baseUrl}/${id}`;
                document.getElementById('edit-column-title-en').value = titleEn;
                document.getElementById('edit-column-title-bn').value = titleBn;
                document.getElementById('edit-column-sort').value = sort;
                document.getElementById('edit-column-active').checked = isActive;
                document.getElementById('edit-column-modal').classList.remove('hidden');
            }

            // Link Modals
            function openAddLinkModal(columnId) {
                const baseUrl = '{{ url("admin/footer/columns") }}';
                document.getElementById('add-link-form').action = `${baseUrl}/${columnId}/links`;
                // Clear fields
                document.getElementById('add-link-form').reset();
                document.getElementById('add-link-modal').classList.remove('hidden');
            }

            function openEditLinkModal(id, titleEn, titleBn, url, sort, isActive) {
                const baseUrl = '{{ url("admin/footer/links") }}';
                document.getElementById('edit-link-form').action = `${baseUrl}/${id}`;
                document.getElementById('edit-link-title-en').value = titleEn;
                document.getElementById('edit-link-title-bn').value = titleBn;
                document.getElementById('edit-link-url').value = url;
                document.getElementById('edit-link-sort').value = sort;
                document.getElementById('edit-link-active').checked = isActive;
                document.getElementById('edit-link-modal').classList.remove('hidden');
            }

            // Close modals on backdrop click
            ['add-column-modal', 'edit-column-modal', 'add-link-modal', 'edit-link-modal'].forEach(id => {
                document.getElementById(id).addEventListener('click', function(e) {
                    if (e.target === this) this.classList.add('hidden');
                });
            });
        </script>
    @endpush
@endsection
