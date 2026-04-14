<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the base tables
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'session_id']);
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->json('options')->nullable();
            $table->timestamps();

            $table->unique(['cart_id', 'product_id']);
            $table->index('cart_id');
            $table->index('product_id');
        });

        // 2. Data Cleanup (Handles existing data if you're running this on a populated DB)
        $duplicates = DB::table('carts')
            ->select('user_id', DB::raw('MIN(id) as keep_id'), DB::raw('COUNT(*) as cnt'))
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->having('cnt', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            $extras = DB::table('carts')
                ->where('user_id', $dup->user_id)
                ->where('id', '!=', $dup->keep_id)
                ->pluck('id');

            foreach ($extras as $extraCartId) {
                $items = DB::table('cart_items')->where('cart_id', $extraCartId)->get();

                foreach ($items as $item) {
                    $existing = DB::table('cart_items')
                        ->where('cart_id', $dup->keep_id)
                        ->where('product_id', $item->product_id)
                        ->first();

                    if ($existing) {
                        DB::table('cart_items')
                            ->where('id', $existing->id)
                            ->increment('quantity', $item->quantity);

                        DB::table('cart_items')->where('id', $item->id)->delete();
                    } else {
                        DB::table('cart_items')
                            ->where('id', $item->id)
                            ->update(['cart_id' => $dup->keep_id]);
                    }
                }
                DB::table('carts')->where('id', $extraCartId)->delete();
            }
        }

        // 3. Apply the Unique Constraint
        Schema::table('carts', function (Blueprint $table) {
            $table->unique('user_id', 'carts_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
