<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService
    ) {}

    /**
     * Show checkout page (from cart)
     */
    public function index()
    {
        $cart = Cart::getCurrentCart();

        // Check if cart is empty
        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        // Check stock for all items
        foreach ($cart->items as $item) {
            if (!$item->product) {
                return redirect()->route('cart.index')
                    ->with('error', 'Some items in your cart are no longer available');
            }

            if (
                $item->product->track_quantity &&
                $item->product->quantity < $item->quantity &&
                !$item->product->allow_backorder
            ) {
                return redirect()->route('cart.index')
                    ->with('error', "{$item->product->name} is out of stock");
            }
        }

        $user = Auth::user();
        $addresses = $user ? $user->addresses()->where('type', 'shipping')->get() : collect();
        $isGuest = !Auth::check();
        $isBuyNow = false; // This is from cart

        return view('frontend.checkout.index', compact('cart', 'user', 'addresses', 'isGuest', 'isBuyNow'));
    }

    /**
     * Buy Now - Direct checkout for single product
     */
    public function buyNow(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $quantity = $validated['quantity'];

        // Check if product exists and is active
        if ($product->status !== 'active') {
            return redirect()->back()
                ->with('error', 'This product is not available');
        }

        // Check stock
        if (
            $product->track_quantity &&
            $product->quantity < $quantity &&
            !$product->allow_backorder
        ) {
            return redirect()->back()
                ->with('error', "{$product->name} is out of stock");
        }

        // Store buy now data in session
        Session::put('buy_now_product', [
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);

        // Redirect to buy now checkout
        return redirect()->route('checkout.buy-now-checkout');
    }

    /**
     * Show Buy Now checkout page
     */
    public function buyNowCheckout()
    {
        // Get buy now data from session
        $buyNowData = Session::get('buy_now_product');

        if (!$buyNowData) {
            return redirect()->route('home')
                ->with('error', 'No product selected for purchase');
        }

        // Get product
        $product = Product::with('category')->findOrFail($buyNowData['product_id']);

        // Check stock again
        if (
            $product->track_quantity &&
            $product->quantity < $buyNowData['quantity'] &&
            !$product->allow_backorder
        ) {
            Session::forget('buy_now_product');
            return redirect()->route('product.show', $product->slug)
                ->with('error', "{$product->name} is out of stock");
        }

        // Create temporary cart-like structure for the view
        $cart = (object) [
            'items' => collect([
                (object) [
                    'product' => $product,
                    'quantity' => $buyNowData['quantity'],
                    'price' => $buyNowData['price'],
                ]
            ]),
            'subtotal' => $buyNowData['price'] * $buyNowData['quantity'],
            'total' => $buyNowData['price'] * $buyNowData['quantity'],
        ];

        $user = Auth::user();
        $addresses = $user ? $user->addresses()->where('type', 'shipping')->get() : collect();
        $isGuest = !Auth::check();
        $isBuyNow = true; // This is buy now

        return view('frontend.checkout.index', compact('cart', 'user', 'addresses', 'isGuest', 'isBuyNow'));
    }

    /**
     * Process checkout (handles both cart and buy now)
     */
    public function process(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,online',
            'notes' => 'nullable|string|max:1000',
            'terms' => 'accepted',
            'is_buy_now' => 'boolean', // Flag to identify buy now
        ];

        // Guest account creation
        if (!Auth::check() && $request->boolean('create_account')) {
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['password'] = 'required|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Determine if this is buy now or cart checkout
        $isBuyNow = $request->boolean('is_buy_now');

        if ($isBuyNow) {
            return $this->processBuyNow($request, $validated);
        } else {
            return $this->processCart($request, $validated);
        }
    }

    /**
     * Process Buy Now checkout
     */
    private function processBuyNow(Request $request, array $validated)
    {
        $buyNowData = Session::get('buy_now_product');

        if (!$buyNowData) {
            return response()->json([
                'success' => false,
                'message' => 'Product data not found'
            ], 400);
        }

        $product = Product::findOrFail($buyNowData['product_id']);

        // Validate stock
        if (
            $product->track_quantity &&
            $product->quantity < $buyNowData['quantity'] &&
            !$product->allow_backorder
        ) {
            Session::forget('buy_now_product');
            return response()->json([
                'success' => false,
                'message' => "{$product->name} is out of stock"
            ], 400);
        }

        try {
            $order = $this->checkoutService->checkoutBuyNow($buyNowData, $validated, $request);
            Session::forget('buy_now_product');

            return response()->json([
                'success' => true,
                'redirect_url' => $this->buildSuccessUrl($order)
            ]);
        } catch (\Throwable $e) {
            Log::error('Buy Now checkout failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Process Cart checkout
     */
    private function processCart(Request $request, array $validated)
    {
        $cart = Cart::getCurrentCart();

        if ($cart->items->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        // Validate stock again
        foreach ($cart->items as $item) {
            if (!$item->product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some items are no longer available'
                ], 400);
            }

            if (
                $item->product->track_quantity &&
                $item->product->quantity < $item->quantity &&
                !$item->product->allow_backorder
            ) {
                return response()->json([
                    'success' => false,
                    'message' => "{$item->product->name} is out of stock"
                ], 400);
            }
        }

        try {
            $order = $this->checkoutService->checkoutCart($cart, $validated, $request);

            return response()->json([
                'success' => true,
                'redirect_url' => $this->buildSuccessUrl($order)
            ]);
        } catch (\Throwable $e) {
            Log::error('Cart checkout failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Show order success page
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items.product')
            ->firstOrFail();

        if (Auth::check()) {
            abort_unless($order->user_id === Auth::id(), 404);
        } else {
            abort_unless($order->canAccessAsGuest(request('access_token')), 404);
        }

        return view('frontend.checkout.success', compact('order'));
    }

    /**
     * Show order failed page
     */
    public function failed()
    {
        return view('frontend.checkout.failed');
    }

    /**
     * Cancel checkout
     */
    public function cancel()
    {
        // Clear buy now session if exists
        Session::forget('buy_now_product');

        return redirect()->route('home')
            ->with('info', 'Checkout cancelled');
    }

    private function buildSuccessUrl(Order $order): string
    {
        $parameters = ['orderNumber' => $order->order_number];

        if (!Auth::check() && $order->guest_access_token) {
            $parameters['access_token'] = $order->guest_access_token;
        }

        return route('checkout.success', $parameters);
    }
}
