@extends('frontend.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
            <p class="text-gray-500 mt-1 text-sm">Manage your personal information and preferences.</p>
        </div>
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-gauge text-gray-500"></i> Dashboard
        </a>
    </div>

    {{-- ── Flash Messages ──────────────────────────────────────────────── --}}
    @if (session('status') === 'profile-updated')
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            Profile updated successfully.
        </div>
    @elseif (session('status') === 'settings-updated')
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            Profile details saved.
        </div>
    @elseif (session('status') === 'address-saved')
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            Address saved successfully.
        </div>
    @elseif (session('status') === 'address-updated')
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            Address updated successfully.
        </div>
    @elseif (session('status') === 'address-deleted')
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            Address removed.
        </div>
    @endif

    @if (session('password_status'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('password_status') }}
        </div>
    @endif

    <div class="space-y-8">

        {{-- ════════════════════════════════════════════════════════════ --}}
        {{-- ── Section 1: Personal Information ──────────────────────── --}}
        {{-- ════════════════════════════════════════════════════════════ --}}
        <div id="personal-info" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Personal Information</h2>
                <p class="text-xs text-gray-400 mt-0.5">Your name, email, and contact number.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="px-6 py-5">
                @csrf
                @method('PATCH')

                @if ($errors->any() && !$errors->hasBag('updatePassword') && !$errors->hasBag('userDeletion'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-400 @enderror"
                               required>
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-red-400 @enderror"
                               required>
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        @if ($user->email_verified_at === null)
                            <p class="mt-1 text-xs text-yellow-600">Email not verified.</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-red-400 @enderror"
                               placeholder="+880 1XXXXXXXXX">
                        @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-5 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary/90 transition-colors">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- ════════════════════════════════════════════════════════════ --}}
        {{-- ── Section 2: Profile Details (extended) ─────────────────── --}}
        {{-- ════════════════════════════════════════════════════════════ --}}
        <div id="profile-details" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Profile Details</h2>
                <p class="text-xs text-gray-400 mt-0.5">Optional details about you.</p>
            </div>

            <form method="POST" action="{{ route('profile.settings.update') }}" class="px-6 py-5">
                @csrf
                @method('PUT')

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                               value="{{ old('date_of_birth', optional($user->profile)->date_of_birth?->format('Y-m-d')) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('date_of_birth') border-red-400 @enderror">
                        @error('date_of_birth') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <select name="gender"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('gender') border-red-400 @enderror">
                            <option value="">Prefer not to say</option>
                            @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other', 'prefer_not_to_say' => 'Prefer not to say'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('gender', optional($user->profile)->gender) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input type="url" name="website"
                               value="{{ old('website', optional($user->profile)->website) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('website') border-red-400 @enderror"
                               placeholder="https://example.com">
                        @error('website') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" name="city"
                               value="{{ old('city', optional($user->profile)->city) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('city') border-red-400 @enderror">
                        @error('city') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State / Division</label>
                        <input type="text" name="state"
                               value="{{ old('state', optional($user->profile)->state) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('state') border-red-400 @enderror">
                        @error('state') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <input type="text" name="country"
                               value="{{ old('country', optional($user->profile)->country) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('country') border-red-400 @enderror">
                        @error('country') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ZIP / Postal Code</label>
                        <input type="text" name="zip_code"
                               value="{{ old('zip_code', optional($user->profile)->zip_code) }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('zip_code') border-red-400 @enderror">
                        @error('zip_code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                        <textarea name="bio" rows="3"
                                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('bio') border-red-400 @enderror"
                                  placeholder="A short introduction about yourself…" maxlength="500">{{ old('bio', optional($user->profile)->bio) }}</textarea>
                        @error('bio') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-5 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary/90 transition-colors">
                        <i class="fa-solid fa-floppy-disk"></i> Save Details
                    </button>
                </div>
            </form>
        </div>

        {{-- ════════════════════════════════════════════════════════════ --}}
        {{-- ── Section 3: Saved Addresses ─────────────────────────────── --}}
        {{-- ════════════════════════════════════════════════════════════ --}}
        <div id="addresses" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-gray-900">Saved Addresses</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Shipping and billing addresses.</p>
                </div>
                <button type="button" onclick="document.getElementById('add-address-form').classList.toggle('hidden')"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-primary px-3 py-2 text-xs font-medium text-white hover:bg-primary/90 transition-colors">
                    <i class="fa-solid fa-plus"></i> Add Address
                </button>
            </div>

            {{-- Add address form (hidden by default) --}}
            <div id="add-address-form" class="hidden px-6 py-5 border-b border-gray-100 bg-gray-50">
                <p class="text-sm font-medium text-gray-800 mb-4">New Address</p>
                <form method="POST" action="{{ route('profile.addresses.store') }}">
                    @csrf
                    @include('customer.partials.address-form')
                    <div class="mt-4 flex items-center gap-3">
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2 text-sm font-medium text-white hover:bg-primary/90 transition-colors">
                            <i class="fa-solid fa-floppy-disk"></i> Save Address
                        </button>
                        <button type="button" onclick="document.getElementById('add-address-form').classList.add('hidden')"
                                class="text-sm text-gray-500 hover:text-gray-700">Cancel</button>
                    </div>
                </form>
            </div>

            {{-- Address list --}}
            @forelse ($user->addresses as $address)
                <div class="px-6 py-5 border-b border-gray-100 last:border-b-0">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                        <div class="text-sm text-gray-700 leading-relaxed">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-block rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $address->type === 'shipping' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ ucfirst($address->type) }}
                                </span>
                                @if ($address->is_default)
                                    <span class="inline-block rounded-full px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700">Default</span>
                                @endif
                            </div>
                            <p class="font-medium text-gray-900">{{ $address->name }}</p>
                            <p>{{ $address->address_line_1 }}{{ $address->address_line_2 ? ', '.$address->address_line_2 : '' }}</p>
                            <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                            <p>{{ $address->country }}</p>
                            <p class="text-gray-500 mt-0.5">{{ $address->phone }}</p>
                        </div>

                        <div class="flex items-center gap-3 flex-shrink-0">
                            <button type="button"
                                    onclick="document.getElementById('edit-address-{{ $address->id }}').classList.toggle('hidden')"
                                    class="text-xs text-primary hover:underline">Edit</button>
                            <form method="POST" action="{{ route('profile.addresses.delete', $address) }}"
                                  onsubmit="return confirm('Delete this address?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>

                    {{-- Inline edit form --}}
                    <div id="edit-address-{{ $address->id }}" class="hidden mt-4 pt-4 border-t border-gray-100">
                        <form method="POST" action="{{ route('profile.addresses.update', $address) }}">
                            @csrf
                            @method('PUT')
                            @include('customer.partials.address-form', ['address' => $address])
                            <div class="mt-4 flex items-center gap-3">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2 text-sm font-medium text-white hover:bg-primary/90 transition-colors">
                                    <i class="fa-solid fa-floppy-disk"></i> Update Address
                                </button>
                                <button type="button"
                                        onclick="document.getElementById('edit-address-{{ $address->id }}').classList.add('hidden')"
                                        class="text-sm text-gray-500 hover:text-gray-700">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-sm text-gray-400">
                    <i class="fa-regular fa-location-dot text-2xl mb-2 block"></i>
                    No saved addresses yet.
                </div>
            @endforelse
        </div>

        {{-- ════════════════════════════════════════════════════════════ --}}
        {{-- ── Section 4: Change Password ──────────────────────────────── --}}
        {{-- ════════════════════════════════════════════════════════════ --}}
        <div id="password" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Change Password</h2>
                <p class="text-xs text-gray-400 mt-0.5">Use a strong password you don't use elsewhere.</p>
            </div>

            <form method="POST" action="{{ route('profile.password.update') }}" class="px-6 py-5">
                @csrf
                @method('PUT')

                @if ($errors->hasBag('updatePassword'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->getBag('updatePassword')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid sm:grid-cols-2 gap-5 max-w-lg">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-red-500">*</span></label>
                        <input type="password" name="current_password" autocomplete="current-password"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('current_password', 'updatePassword') border-red-400 @enderror"
                               required>
                        @error('current_password', 'updatePassword') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" autocomplete="new-password"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('password', 'updatePassword') border-red-400 @enderror"
                               required>
                        @error('password', 'updatePassword') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" autocomplete="new-password"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               required>
                    </div>
                </div>

                <div class="mt-5 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary/90 transition-colors">
                        <i class="fa-solid fa-lock"></i> Update Password
                    </button>
                </div>
            </form>
        </div>

        {{-- ════════════════════════════════════════════════════════════ --}}
        {{-- ── Section 5: Delete Account ───────────────────────────────── --}}
        {{-- ════════════════════════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl border border-red-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-red-100">
                <h2 class="font-semibold text-red-700">Delete Account</h2>
                <p class="text-xs text-red-400 mt-0.5">This action is permanent and cannot be undone.</p>
            </div>

            <div class="px-6 py-5">
                <p class="text-sm text-gray-600 mb-4">
                    Once your account is deleted, all of your data will be permanently removed.
                    Before deleting, please download any data or information that you wish to retain.
                </p>

                @if ($errors->hasBag('userDeletion'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        @foreach ($errors->getBag('userDeletion')->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <button type="button" onclick="document.getElementById('delete-account-modal').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 rounded-lg border border-red-300 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    <i class="fa-solid fa-trash-can"></i> Delete My Account
                </button>
            </div>
        </div>

    </div>{{-- end .space-y-8 --}}
</div>{{-- end container --}}

{{-- ── Delete Account Modal ────────────────────────────────────────────── --}}
<div id="delete-account-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Are you absolutely sure?</h3>
        <p class="text-sm text-gray-500 mb-5">
            Enter your password to confirm account deletion. This cannot be undone.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" autocomplete="current-password"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                       placeholder="Enter your password" required>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="flex-1 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                    Yes, delete my account
                </button>
                <button type="button" onclick="document.getElementById('delete-account-modal').classList.add('hidden')"
                        class="flex-1 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
