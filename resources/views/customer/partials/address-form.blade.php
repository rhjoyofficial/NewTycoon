{{--
    Reusable address fields partial.
    Usage: @include('customer.partials.address-form') — for new address
           @include('customer.partials.address-form', ['address' => $address]) — for edit
--}}
@php $a = $address ?? null; @endphp

<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Address Type <span class="text-red-500">*</span></label>
        <select name="type"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                required>
            <option value="shipping" @selected(old('type', optional($a)->type) === 'shipping')>Shipping</option>
            <option value="billing"  @selected(old('type', optional($a)->type) === 'billing')>Billing</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', optional($a)->name) }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" value="{{ old('email', optional($a)->email) }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
        <input type="text" name="phone" value="{{ old('phone', optional($a)->phone) }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               required>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
        <input type="text" name="address_line_1" value="{{ old('address_line_1', optional($a)->address_line_1) }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               required>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
        <input type="text" name="address_line_2" value="{{ old('address_line_2', optional($a)->address_line_2) }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               placeholder="Apartment, floor, suite, etc. (optional)">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
        <input type="text" name="city" value="{{ old('city', optional($a)->city) }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">State / Division <span class="text-red-500">*</span></label>
        <input type="text" name="state" value="{{ old('state', optional($a)->state) }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code <span class="text-red-500">*</span></label>
        <input type="text" name="postal_code" value="{{ old('postal_code', optional($a)->postal_code) }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
        <input type="text" name="country" value="{{ old('country', optional($a)->country ?? 'Bangladesh') }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
               required>
    </div>

    <div class="sm:col-span-2 flex items-center gap-2">
        <input type="checkbox" name="is_default" value="1" id="is_default_{{ $a ? $a->id : 'new' }}"
               class="rounded border-gray-300 text-primary focus:ring-primary"
               @checked(old('is_default', optional($a)->is_default))>
        <label for="is_default_{{ $a ? $a->id : 'new' }}" class="text-sm text-gray-700">Set as default address</label>
    </div>
</div>
