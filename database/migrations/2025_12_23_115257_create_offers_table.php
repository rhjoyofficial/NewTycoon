<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn')->nullable();
            $table->string('short_des_en')->nullable();
            $table->string('short_des_bn')->nullable();
            $table->string('slug')->unique();
            $table->text('subtitle_en')->nullable();
            $table->text('subtitle_bn')->nullable();
            $table->string('main_banner_image')->nullable();
            $table->boolean('timer_enabled')->default(true);
            $table->datetime('timer_end_date')->nullable();
            $table->string('view_all_link')->nullable();
            $table->string('view_all_text')->default('View All');
            $table->enum('product_source', ['manual', 'discount', 'category', 'tag'])->default('manual');
            $table->json('source_config')->nullable(); // For storing source-specific configuration
            $table->integer('product_limit')->default(12);
            $table->enum('status', ['draft', 'active', 'inactive', 'scheduled'])->default('draft');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->integer('order')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('click_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('slug');
            $table->index('status');
            $table->index('order');
            $table->index(['status', 'start_date', 'end_date']);
        });

        Schema::create('offer_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->json('custom_data')->nullable(); // For custom title, image, etc.
            $table->timestamps();

            $table->unique(['offer_id', 'product_id']);
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_products');
        Schema::dropIfExists('offers');
    }
};
