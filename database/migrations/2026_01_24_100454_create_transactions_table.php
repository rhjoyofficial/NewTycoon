<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->enum('type', ['payment', 'refund', 'adjustment'])->default('payment');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');

            $table->string('payment_method')->nullable();
            $table->string('gateway')->nullable();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('reference_number')->nullable();

            $table->text('description')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('order_id');
            $table->index('user_id');
            $table->index('type');
            $table->index('status');
            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
