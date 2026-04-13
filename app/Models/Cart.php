<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_id'];

    public function hasItem(int $productId): bool
    {
        return $this->items->contains('product_id', $productId);
    }

    /**
     * Get the cart for the current user/session.
     *
     * NOTE: Guest→user cart merging is NOT done here because session()->regenerate()
     * in the login controller changes the session ID before this method ever runs.
     * Merging is performed explicitly via Cart::mergeGuestCart() in
     * AuthenticatedSessionController::store() using the pre-regeneration session ID.
     */
    public static function getCurrentCart(): static
    {
        if (Auth::check()) {
            return DB::transaction(function () {
                return self::firstOrCreate(['user_id' => Auth::id()]);
            });
        }

        return self::firstOrCreate(['session_id' => Session::getId()]);
    }

    /**
     * Merge the guest cart (identified by the pre-regeneration session ID) into
     * the authenticated user's cart. Called once, immediately after login.
     *
     * Uses a DB transaction + row-level locks to be safe under concurrent requests.
     */
    public static function mergeGuestCart(string $guestSessionId): void
    {
        if (!Auth::check()) {
            return;
        }

        DB::transaction(function () use ($guestSessionId) {
            $sessionCart = self::where('session_id', $guestSessionId)
                ->whereNull('user_id')
                ->lockForUpdate()
                ->first();

            if (!$sessionCart || $sessionCart->items->isEmpty()) {
                return;
            }

            $userCart = self::firstOrCreate(['user_id' => Auth::id()]);
            $userCart->mergeCart($sessionCart);
            $sessionCart->delete();
        });
    }

    /**
     * Merge another cart's items into this cart.
     * Wrapped in a transaction with row locks — safe to call from a parent transaction.
     */
    public function mergeCart(Cart $otherCart): void
    {
        DB::transaction(function () use ($otherCart) {
            foreach ($otherCart->fresh()->items as $item) {
                $existingItem = $this->items()
                    ->where('product_id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($existingItem) {
                    // Atomic increment — avoids read-modify-write race condition
                    $existingItem->increment('quantity', $item->quantity);
                } else {
                    $this->items()->create([
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->price,
                        'options'    => $item->options,
                    ]);
                }
            }
        });
    }

    /**
     * Get cart items
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get total items count
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    /**
     * Get subtotal (without tax/shipping)
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }
    public function getItemTotal(int $productId): float
    {
        $item = $this->items->firstWhere('product_id', $productId);
        return $item ? ($item->quantity * $item->price) : 0;
    }
    /**
     * Clear cart
     */
    public function clear()
    {
        $this->items()->delete();
    }

    /**
     * Add item to cart
     */
    public function addItem($productId, $quantity = 1, $options = [])
    {
        return DB::transaction(function () use ($productId, $quantity, $options) {

            $product = Product::lockForUpdate()->findOrFail($productId);

            // Stock check (now atomic)
            if ($product->track_quantity && $product->quantity < $quantity && !$product->allow_backorder) {
                throw new \Exception('Product out of stock');
            }

            $item = $this->items()
                ->where('product_id', $productId)
                ->lockForUpdate()
                ->first();

            if ($item) {
                $item->increment('quantity', $quantity);
            } else {
                $item = $this->items()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'options' => $options
                ]);
            }

            return $item;
        });
    }

    /**
     * Update item quantity
     */
    public function updateItem($productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }

        $item = $this->items()
            ->where('product_id', $productId)
            ->firstOrFail();

        $item->update(['quantity' => $quantity]);

        return $item;
    }


    /**
     * Remove item from cart
     */
    public function removeItem($productId): bool
    {
        return (bool) $this->items()
            ->where('product_id', $productId)
            ->delete();
    }
}
