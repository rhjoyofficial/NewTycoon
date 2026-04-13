<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_columns', function (Blueprint $table) {
            $table->id();

            // Localized titles
            $table->string('title_en');
            $table->string('title_bn')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });


        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_column_id')->constrained()->cascadeOnDelete();

            // Localized titles
            $table->string('title_en');
            $table->string('title_bn')->nullable();

            $table->string('url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });


        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();

            $table->string('brand_name')->default('TYCOON');

            // Localized descriptions
            $table->text('brand_description_en');
            $table->text('brand_description_bn')->nullable();

            $table->string('address_en')->nullable();
            $table->string('address_bn')->nullable();

            $table->json('contact_info')->nullable();

            $table->json('payment_methods')->nullable();
            $table->json('social_links')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_links');
        Schema::dropIfExists('footer_columns');
        Schema::dropIfExists('footer_settings');
    }
};
