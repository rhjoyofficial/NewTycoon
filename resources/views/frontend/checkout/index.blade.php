@extends('frontend.layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-poppins font-bold text-gray-900 mb-2">Checkout</h1>
                <p class="text-gray-600">Complete your order</p>
            </div>

            <form id="checkoutForm" class="grid lg:grid-cols-3 gap-6">
                @csrf

                {{-- Left: Shipping & Payment --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Contact Information --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Contact Information</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    required>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                        placeholder="01XXXXXXXXX"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Address --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Shipping Address</h2>

                        {{-- Saved Addresses (for logged-in users) --}}
                        @if ($user && $addresses->count() > 0)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select saved address</label>
                                <div class="space-y-2">
                                    @foreach ($addresses as $address)
                                        <label
                                            class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-primary">
                                            <input type="radio" name="saved_address" value="{{ $address->id }}"
                                                data-address="{{ json_encode($address) }}"
                                                class="mt-1 text-primary focus:ring-primary"
                                                {{ $loop->first && $address->is_default ? 'checked' : '' }}>
                                            <div class="ml-3 text-sm">
                                                <div class="font-medium text-gray-900">{{ $address->first_name }}</div>
                                                <div class="text-gray-600">
                                                    {{ $address->address_line_1 }}<br>
                                                    {{ $address->city }}, {{ $address->postal_code }}<br>
                                                    {{ $address->phone }}
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <label class="flex items-center text-sm">
                                        <input type="radio" name="saved_address" value="new" class="text-primary"
                                            {{ $addresses->count() === 0 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Use a new address</span>
                                    </label>
                                </div>
                            </div>
                        @endif

                        {{-- Address Form --}}
                        <div id="addressForm" class="space-y-4 {{ $user && $addresses->count() > 0 ? 'hidden' : '' }}">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                                <input type="text" name="address" placeholder="House/Flat, Road, Area"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    required>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                    <select name="city"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                        required>
                                        <option value="">Select City</option>
                                        <option value="Dhaka">Dhaka</option>
                                        <option value="Chattogram">Chattogram</option>
                                        <option value="Rajshahi">Rajshahi</option>
                                        <option value="Khulna">Khulna</option>
                                        <option value="Sylhet">Sylhet</option>
                                        <option value="Barishal">Barishal</option>
                                        <option value="Rangpur">Rangpur</option>
                                        <option value="Mymensingh">Mymensingh</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                                    <input type="text" name="postal_code" placeholder="1200"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Method</h2>

                        <div class="space-y-3">
                            <label
                                class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="cod" class="text-primary" checked>
                                    <div class="ml-3">
                                        <div class="font-medium text-gray-900">Cash on Delivery</div>
                                        <div class="text-sm text-gray-600">Pay when you receive</div>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                    <path fill-rule="evenodd"
                                        d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </label>

                            <label
                                class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary opacity-50">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="online" class="text-primary"
                                        disabled>
                                    <div class="ml-3">
                                        <div class="font-medium text-gray-900">Online Payment</div>
                                        <div class="text-sm text-gray-600">bKash, Nagad, Card (Coming Soon)</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Order Notes --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Notes (Optional)</label>
                        <textarea name="notes" rows="3" placeholder="Special delivery instructions..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                    </div>
                </div>

                {{-- Right: Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg border border-gray-200 p-6 sticky top-4">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>

                        {{-- Items --}}
                        <div class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                            @foreach ($cart->items as $item)
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gray-100 rounded flex-shrink-0 overflow-hidden">
                                        @if ($item->product && $item->product->featured_image_url)
                                            <img src="{{ asset($item->product->featured_image_url) }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ $item->product ? $item->product->name : 'Product' }}
                                        </div>
                                        <div class="text-xs text-gray-500">Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">
                                        <span
                                            class="font-bengali">৳</span>{{ number_format($item->quantity * $item->price, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Totals --}}
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-semibold"><span
                                        class="font-bengali">৳</span>{{ number_format($cart->subtotal, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="font-semibold text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t">
                                <span>Total</span>
                                <span><span class="font-bengali">৳</span>{{ number_format($cart->subtotal, 0) }}</span>
                            </div>
                        </div>

                        {{-- Terms --}}
                        <div class="mt-6 pt-4 border-t">
                            <label class="flex items-start text-sm">
                                <input type="checkbox" name="terms" class="mt-0.5 rounded border-gray-300 text-primary"
                                    required>
                                <span class="ml-2 text-gray-700">
                                    I agree to the <a href="#" class="text-primary hover:underline">Terms &
                                        Conditions</a>
                                </span>
                            </label>
                        </div>

                        {{-- Guest: Create Account --}}
                        @if ($isGuest)
                            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                <label class="flex items-start text-sm">
                                    <input type="checkbox" name="create_account" id="createAccountCheckbox"
                                        class="mt-0.5 rounded border-gray-300 text-primary">
                                    <span class="ml-2 text-gray-700">Create an account for faster checkout next time</span>
                                </label>

                                <div id="passwordFields" class="mt-3 space-y-3 hidden">
                                    <div>
                                        <input type="password" name="password" placeholder="Password (min 8 characters)"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    </div>
                                    <div>
                                        <input type="password" name="password_confirmation"
                                            placeholder="Confirm Password"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Place Order Button --}}
                        <button type="submit" id="placeOrderBtn"
                            class="w-full mt-6 bg-primary hover:bg-primary-dark text-white font-semibold py-3 rounded-lg transition-colors">
                            Place Order
                        </button>

                        {{-- Back to Cart --}}
                        <a href="{{ route('cart.index') }}"
                            class="block text-center mt-3 text-sm text-gray-600 hover:text-primary">
                            ← Back to Cart
                        </a>

                        {{-- Security --}}
                        <div class="mt-4 text-center">
                            <div class="inline-flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Secure Checkout
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkoutForm');
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const createAccountCheckbox = document.getElementById('createAccountCheckbox');
            const passwordFields = document.getElementById('passwordFields');
            const addressForm = document.getElementById('addressForm');

            // Toggle password fields for guest account creation
            if (createAccountCheckbox) {
                createAccountCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        passwordFields.classList.remove('hidden');
                        passwordFields.querySelectorAll('input').forEach(input => input.required = true);
                    } else {
                        passwordFields.classList.add('hidden');
                        passwordFields.querySelectorAll('input').forEach(input => input.required = false);
                    }
                });
            }

            // Handle saved address selection
            document.querySelectorAll('input[name="saved_address"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'new') {
                        addressForm.classList.remove('hidden');
                        addressForm.querySelectorAll('input, select').forEach(input => input
                            .required = true);
                    } else {
                        addressForm.classList.add('hidden');
                        addressForm.querySelectorAll('input, select').forEach(input => input
                            .required = false);

                        // Fill form with saved address data
                        const addressData = JSON.parse(this.dataset.address);
                        document.querySelector('input[name="address"]').value = addressData
                            .address_line_1;
                        document.querySelector('select[name="city"]').value = addressData.city;
                        document.querySelector('input[name="postal_code"]').value = addressData
                            .postal_code;
                    }
                });
            });

            // Form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Disable button
                placeOrderBtn.disabled = true;
                placeOrderBtn.innerHTML =
                    '<svg class="animate-spin h-5 w-5 mx-auto" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                try {
                    const formData = new FormData(this);
                    const response = await fetch('{{ route('checkout.process') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Checkout failed. Please try again.');
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.innerHTML = 'Place Order';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                    placeOrderBtn.disabled = false;
                    placeOrderBtn.innerHTML = 'Place Order';
                }
            });
        });
    </script>
@endpush
