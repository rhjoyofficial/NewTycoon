@extends('frontend.layouts.app')

@section('title', 'Order Confirmed')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-2xl mx-auto px-4">
            {{-- Success Icon --}}
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
                <p class="text-gray-600">Thank you for your order. We'll process it shortly.</p>
            </div>

            {{-- Order Details --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Order Details</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Number</span>
                        <span class="font-semibold text-gray-900">{{ $order->order_number }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Date</span>
                        <span class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method</span>
                        <span class="font-semibold text-gray-900">
                            {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}
                        </span>
                    </div>

                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-gray-600">Total Amount</span>
                        <span class="text-xl font-bold text-gray-900"><span
                                class="font-bengali">৳</span>{{ number_format($order->total_amount, 0) }}</span>
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-3">Shipping To</h2>
                <div class="text-sm text-gray-700">
                    <p class="font-semibold">{{ $order->shipping_name }}</p>
                    <p>{{ $order->shipping_phone }}</p>
                    <p>{{ $order->shipping_address_line1 }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_zip_code }}</p>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Order Items</h2>
                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-3 pb-3 border-b last:border-0">
                            <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                @if ($item->product_image)
                                    <img src="{{ asset('storage/' . $item->product_image) }}"
                                        alt="{{ $item->product_name }}" class="w-full h-full object-contain">
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 text-sm">{{ $item->product_name }}</div>
                                <div class="text-xs text-gray-500">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div class="text-sm font-semibold text-gray-900">
                                <span class="font-bengali">৳</span> {{ number_format($item->total_price, 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- What's Next --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-3">What's Next?</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Order confirmation email sent to {{ $order->customer_email }}</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>We'll notify you when your order ships</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Estimated delivery: 3-5 business days</span>
                    </li>
                    @if ($order->payment_method === 'cod')
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Please keep exact cash ready (<span
                                    class="font-bengali">৳</span>{{ number_format($order->total_amount, 0) }}) for
                                delivery</span>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3">
                @auth
                    <a href="{{ route('account.orders') }}"
                        class="flex-1 text-center px-6 py-3 border-2 border-primary text-primary hover:bg-primary-light rounded-lg font-semibold transition-colors">
                        View My Orders
                    </a>
                @endauth

                <a href="{{ route('products.index') }}"
                    class="flex-1 text-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors">
                    Continue Shopping
                </a>
            </div>

            {{-- Support --}}
            <div class="text-center mt-8 pt-6 border-t">
                <p class="text-sm text-gray-600">
                    Need help? <a href="{{ route('contact') }}" class="text-primary hover:underline font-medium">Contact
                        Support</a>
                </p>
            </div>
        </div>
    </div>
@endsection
