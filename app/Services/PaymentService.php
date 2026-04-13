<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Str;

class PaymentService
{
    public function createPendingPayment(Order $order, string $paymentMethod, ?string $gateway = null, array $metadata = []): Payment
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'payment_gateway' => $gateway,
            'amount' => $order->total_amount,
            'status' => 'pending',
            'reference_number' => 'PAY-' . strtoupper(Str::random(12)),
            'metadata' => $metadata,
        ]);

        Transaction::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'type' => 'payment',
            'amount' => $order->total_amount,
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'gateway' => $gateway,
            'reference_number' => $payment->reference_number,
            'description' => 'Checkout payment initiated.',
            'metadata' => $metadata,
        ]);

        $order->forceFill([
            'payment_method' => $paymentMethod,
            'payment_gateway' => $gateway,
        ])->save();

        return $payment;
    }

    public function syncOrderPaymentStatus(Order $order, string $paymentStatus, ?string $transactionId = null, ?string $gateway = null): void
    {
        $payment = $order->payment()->latest()->first();

        if (!$payment) {
            $payment = $this->createPendingPayment($order, $order->payment_method, $gateway);
        }

        $paymentState = match ($paymentStatus) {
            'paid' => 'completed',
            'failed' => 'failed',
            'refunded', 'partially_refunded' => 'refunded',
            default => 'pending',
        };

        if ($payment) {
            $payment->update([
                'status' => $paymentState,
                'transaction_id' => $transactionId ?? $payment->transaction_id,
                'payment_gateway' => $gateway ?? $payment->payment_gateway,
                'paid_at' => $paymentStatus === 'paid' ? now() : null,
            ]);
        }

        $order->update([
            'payment_status' => $paymentStatus,
            'transaction_id' => $transactionId ?? $order->transaction_id,
            'payment_gateway' => $gateway ?? $order->payment_gateway,
            'paid_at' => $paymentStatus === 'paid' ? now() : null,
        ]);

        $transaction = $order->transactions()
            ->where('type', 'payment')
            ->latest()
            ->first();

        if ($transaction) {
            $transaction->update([
                'status' => match ($paymentStatus) {
                    'paid' => 'completed',
                    'failed' => 'failed',
                    'refunded', 'partially_refunded' => 'cancelled',
                    default => 'pending',
                },
                'transaction_id' => $transactionId ?? $transaction->transaction_id,
                'gateway' => $gateway ?? $transaction->gateway,
                'processed_at' => in_array($paymentStatus, ['paid', 'failed', 'refunded', 'partially_refunded'], true) ? now() : null,
            ]);
        }
    }
}
