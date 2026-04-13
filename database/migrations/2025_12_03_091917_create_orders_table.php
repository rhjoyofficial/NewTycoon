<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();

            // Customer information
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_email');
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();

            // Shipping address
            $table->string('shipping_name');
            $table->string('shipping_email');
            $table->string('shipping_phone');
            $table->string('shipping_address_line1');
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_country');
            $table->string('shipping_zip_code');

            // Billing address (can be same as shipping)
            $table->boolean('billing_same_as_shipping')->default(true);
            $table->string('billing_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_address_line1')->nullable();
            $table->string('billing_address_line2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_zip_code')->nullable();

            // Order details
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2);

            // Payment information
            $table->string('payment_method');
            $table->string('payment_gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'partially_refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();

            // Shipping information
            $table->string('shipping_method');
            $table->decimal('shipping_weight', 8, 2)->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('carrier')->nullable();

            // Order status
            $table->enum('status', [
                'pending',
                'processing',
                'on_hold',
                'completed',
                'cancelled',
                'refunded',
                'failed'
            ])->default('pending');

            $table->timestamp('processing_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            // Notes
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->text('cancellation_reason')->nullable();

            // Metadata
            $table->json('metadata')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses')->nullOnDelete();

            $table->string('guest_access_token_hash', 64)->nullable()->index();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('order_number');
            $table->index('user_id');
            $table->index('status');
            $table->index('payment_status');
            $table->index('created_at');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
