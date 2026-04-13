<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_gateway',
        'amount',
        'status',
        'transaction_id',
        'reference_number',
        'paid_at',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the order for this payment
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Mark payment as completed
     */
    public function markAsCompleted($transactionId = null)
    {
        $this->update([
            'status' => 'completed',
            'transaction_id' => $transactionId ?? $this->transaction_id,
            'paid_at' => now(),
        ]);

        // Update order payment status
        $this->order->markAsPaid($transactionId);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed($reason = null)
    {
        $this->update([
            'status' => 'failed',
            'metadata' => array_merge($this->metadata ?? [], [
                'failure_reason' => $reason,
                'failed_at' => now()->toDateTimeString(),
            ]),
        ]);
    }

    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payment is failed
     */
    public function isFailed()
    {
        return $this->status === 'failed';
    }
}
