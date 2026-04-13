<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    public ?string $guest_access_token = null;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_email',
        'customer_name',
        'customer_phone',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address_line1',
        'shipping_address_line2',
        'shipping_city',
        'shipping_state',
        'shipping_country',
        'shipping_zip_code',
        'billing_same_as_shipping',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address_line1',
        'billing_address_line2',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_zip_code',
        'subtotal',
        'shipping_cost',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_gateway',
        'transaction_id',
        'payment_status',
        'paid_at',
        'shipping_method',
        'shipping_weight',
        'tracking_number',
        'carrier',
        'status',
        'processing_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'customer_note',
        'admin_note',
        'cancellation_reason',
        'metadata',
        'ip_address',
        'user_agent',
        'guest_access_token_hash',
    ];

    protected $casts = [
        'billing_same_as_shipping' => 'boolean',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipping_weight' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'processing_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }

            // If billing same as shipping, copy shipping info to billing
            if ($order->billing_same_as_shipping && empty($order->billing_name)) {
                $order->billing_name = $order->shipping_name;
                $order->billing_email = $order->shipping_email;
                $order->billing_phone = $order->shipping_phone;
                $order->billing_address_line1 = $order->shipping_address_line1;
                $order->billing_address_line2 = $order->shipping_address_line2;
                $order->billing_city = $order->shipping_city;
                $order->billing_state = $order->shipping_state;
                $order->billing_country = $order->shipping_country;
                $order->billing_zip_code = $order->shipping_zip_code;
            }
        });
    }

    /**
     * Get the user that placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the transactions for the order.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }
    /**
     * Get the order's shipping address.
     */
    public function getShippingAddressAttribute()
    {
        return implode(', ', array_filter([
            $this->shipping_address_line1,
            $this->shipping_address_line2,
            $this->shipping_city,
            $this->shipping_state,
            $this->shipping_country,
            $this->shipping_zip_code
        ]));
    }

    /**
     * Get the order's billing address.
     */
    public function getBillingAddressAttribute()
    {
        if ($this->billing_same_as_shipping) {
            return $this->shipping_address;
        }

        return implode(', ', array_filter([
            $this->billing_address_line1,
            $this->billing_address_line2,
            $this->billing_city,
            $this->billing_state,
            $this->billing_country,
            $this->billing_zip_code
        ]));
    }

    /**
     * Check if order is paid.
     */
    public function getIsPaidAttribute()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if order is completed.
     */
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if order is pending.
     */
    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if order is cancelled.
     */
    public function getIsCancelledAttribute()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Mark order as paid.
     */
    public function markAsPaid($transactionId = null, $gateway = null)
    {
        $this->update([
            'payment_status' => 'paid',
            'transaction_id' => $transactionId ?? $this->transaction_id,
            'payment_gateway' => $gateway ?? $this->payment_gateway,
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark order as processing.
     */
    public function markAsProcessing()
    {
        $this->update([
            'status' => 'processing',
            'processing_at' => now(),
        ]);
    }

    /**
     * Mark order as shipped.
     */
    public function markAsShipped($trackingNumber = null, $carrier = null)
    {
        $this->update([
            'status' => 'processing',
            'tracking_number' => $trackingNumber ?? $this->tracking_number,
            'carrier' => $carrier ?? $this->carrier,
            'shipped_at' => now(),
        ]);
    }

    /**
     * Mark order as delivered.
     */
    public function markAsDelivered()
    {
        $this->update([
            'status' => 'completed',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Cancel the order.
     *
     * Guards against double-cancellation: calling this on an already-cancelled
     * order would otherwise call reverseSale() twice, double-restoring stock.
     */
    public function cancel($reason = null): void
    {
        if ($this->status === 'cancelled') {
            return;
        }

        $this->update([
            'status'              => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at'        => now(),
        ]);

        // Restore stock for every item.  Load fresh from DB to avoid stale
        // collection if cancel() is called from within a transaction that
        // has already mutated the items.
        foreach ($this->items()->with('product')->get() as $item) {
            if ($item->product) {
                $item->product->reverseSale($item->quantity, (float) $item->unit_price);
            }
        }
    }

    /**
     * Refund the order.
     *
     * Guards against double-refunds so that calling this twice does not
     * create duplicate Transaction records or double-update payment status.
     */
    public function refund($amount = null, bool $full = true): void
    {
        if (in_array($this->payment_status, ['refunded', 'partially_refunded'], true)) {
            return;
        }

        $refundAmount = $full ? (float) $this->total_amount : (float) $amount;

        $this->update([
            'payment_status' => 'refunded',
            'status'         => 'refunded',
        ]);

        Transaction::create([
            'order_id'       => $this->id,
            'user_id'        => $this->user_id,
            'type'           => 'refund',
            'amount'         => $refundAmount,
            'status'         => 'completed',
            'gateway'        => $this->payment_gateway,
            'transaction_id' => 'REF-' . strtoupper(Str::random(10)),
            'processed_at'   => now(),
        ]);

        $this->payments()->update(['status' => 'refunded']);
    }

    public static function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (static::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    public function canAccessAsGuest(?string $plainToken): bool
    {
        if (blank($plainToken) || blank($this->guest_access_token_hash)) {
            return false;
        }

        return hash_equals($this->guest_access_token_hash, hash('sha256', $plainToken));
    }

    /**
     * Calculate total items quantity.
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    /**
     * Calculate total after discounts.
     */
    public function getTotalAfterDiscountAttribute()
    {
        return $this->subtotal - $this->discount_amount;
    }

    /**
     * Calculate tax rate percentage.
     */
    public function getTaxRateAttribute()
    {
        if ($this->subtotal > 0) {
            return ($this->tax_amount / $this->subtotal) * 100;
        }

        return 0;
    }

    /**
     * Scope a query to only include orders from a specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include orders with a specific status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include orders with a specific payment status.
     */
    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    /**
     * Scope a query to search orders.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('order_number', 'LIKE', "%{$search}%")
                ->orWhere('customer_email', 'LIKE', "%{$search}%")
                ->orWhere('customer_name', 'LIKE', "%{$search}%")
                ->orWhere('customer_phone', 'LIKE', "%{$search}%")
                ->orWhere('transaction_id', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get order status badge color.
     */
    public function getStatusBadgeColorAttribute()
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'on_hold' => 'bg-orange-100 text-orange-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            'failed' => 'bg-gray-100 text-gray-800',
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get payment status badge color.
     */
    public function getPaymentStatusBadgeColorAttribute()
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            'partially_refunded' => 'bg-orange-100 text-orange-800',
        ];

        return $colors[$this->payment_status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get the payment for this order
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get all payments for this order
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
