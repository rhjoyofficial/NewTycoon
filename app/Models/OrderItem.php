<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'product_image',
        'unit_price',
        'quantity',
        'total_price',
        'discount_amount',
        'tax_amount',
        'attributes',
        'is_refunded',
        'refunded_quantity',
        'refunded_amount',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'attributes' => 'array',
        'is_refunded' => 'boolean',
        'refunded_quantity' => 'integer',
        'refunded_amount' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the item price after discount.
     */
    public function getPriceAfterDiscountAttribute()
    {
        return $this->unit_price - ($this->discount_amount / $this->quantity);
    }

    /**
     * Get the item price including tax.
     */
    public function getPriceWithTaxAttribute()
    {
        return $this->unit_price + ($this->tax_amount / $this->quantity);
    }

    /**
     * Get the total price after discount.
     */
    public function getTotalAfterDiscountAttribute()
    {
        return $this->total_price - $this->discount_amount;
    }

    /**
     * Get the total price including tax.
     */
    public function getTotalWithTaxAttribute()
    {
        return $this->total_price + $this->tax_amount;
    }

    /**
     * Check if item is fully refunded.
     */
    public function getIsFullyRefundedAttribute()
    {
        return $this->refunded_quantity >= $this->quantity;
    }

    /**
     * Check if item is partially refunded.
     */
    public function getIsPartiallyRefundedAttribute()
    {
        return $this->refunded_quantity > 0 && $this->refunded_quantity < $this->quantity;
    }

    /**
     * Get the remaining quantity that can be refunded.
     */
    public function getRefundableQuantityAttribute()
    {
        return $this->quantity - $this->refunded_quantity;
    }

    /**
     * Get the remaining amount that can be refunded.
     */
    public function getRefundableAmountAttribute()
    {
        $pricePerUnit = $this->unit_price - ($this->discount_amount / $this->quantity);
        return $this->refundable_quantity * $pricePerUnit;
    }

    /**
     * Refund this item.
     */
    public function refund($quantity, $amount = null)
    {
        $quantity = min($quantity, $this->refundable_quantity);
        
        if ($quantity <= 0) {
            return false;
        }

        $this->refunded_quantity += $quantity;
        
        if ($amount) {
            $this->refunded_amount += $amount;
        } else {
            $pricePerUnit = $this->unit_price - ($this->discount_amount / $this->quantity);
            $this->refunded_amount += $quantity * $pricePerUnit;
        }

        if ($this->refunded_quantity >= $this->quantity) {
            $this->is_refunded = true;
        }

        $this->save();

        // Update product stock if needed
        if ($this->product && $this->product->track_quantity) {
            $this->product->reverseSale($quantity, (float) $this->unit_price);
        }

        return true;
    }
}
