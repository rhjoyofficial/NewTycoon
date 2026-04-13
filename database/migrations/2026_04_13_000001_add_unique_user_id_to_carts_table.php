<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Deduplicate: if somehow two carts exist for the same user_id (race
        // condition before this constraint existed), keep the most recent one
        // and move its items onto the oldest cart, then drop the duplicate.
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
                // Re-home items from the duplicate cart onto the cart we're keeping,
                // merging quantities where the same product_id already exists.
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

        Schema::table('carts', function (Blueprint $table) {
            // MySQL allows multiple NULLs in a unique column, so guest carts
            // (user_id = NULL) are unaffected. Only authenticated user carts
            // are constrained to one row per user.
            $table->unique('user_id', 'carts_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropUnique('carts_user_id_unique');
        });
    }
};
