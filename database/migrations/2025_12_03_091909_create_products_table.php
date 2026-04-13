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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn')->nullable();

            $table->text('short_description_en')->nullable();
            $table->text('short_description_bn')->nullable();

            $table->longText('description_en')->nullable();
            $table->longText('description_bn')->nullable();

            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_bn')->nullable();

            $table->text('meta_description_en')->nullable();
            $table->text('meta_description_bn')->nullable();

            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->integer('discount_percentage')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('alert_quantity')->default(5);
            $table->boolean('track_quantity')->default(true);
            $table->boolean('allow_backorder')->default(false);
            $table->string('model_number')->nullable()->index();
            $table->unsignedSmallInteger('warranty_duration')->nullable(); // numeric value
            $table->enum('warranty_unit', ['days', 'months', 'years'])->nullable();
            $table->enum('warranty_type', ['replacement', 'service', 'parts'])->nullable();

            $table->json('specifications')->nullable();

            // Media
            $table->json('featured_images')->nullable();
            $table->json('gallery_images')->nullable();

            // Attributes
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();

            // SEO           
            $table->string('meta_keywords')->nullable();

            // Status flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestsells')->default(false);
            $table->boolean('is_new')->default(true);
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'backorder'])->default('in_stock');

            // Ratings
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);

            // Sales data
            $table->integer('total_sold')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);

            // Relationships
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('users')->nullOnDelete();

            $table->unsignedBigInteger('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('name_en');
            $table->index('name_bn');
            $table->index('category_id');
            $table->index('vendor_id');
            $table->index('status');
            $table->index('stock_status');
            $table->index('is_featured');
            $table->index('price');
            $table->index('slug');
            $table->index('sku');
            $table->index(['status', 'views_count']);
            $table->index(['category_id', 'status']);
            $table->index(['category_id', 'price']);
            $table->index(['status', 'stock_status']);
            $table->index(['status', 'is_featured']);
            $table->index(['status', 'is_new']);
            $table->index(['status', 'is_bestsells']);
            $table->index(['status', 'total_sold']);
            $table->index(['status', 'average_rating']);
            $table->index(['status', 'discount_percentage']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
