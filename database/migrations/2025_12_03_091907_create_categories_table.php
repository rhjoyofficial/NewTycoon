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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Bilingual fields
            $table->string('name_en');
            $table->string('name_bn')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();

            // Core fields
            $table->string('slug')->unique();
            $table->string('image')->nullable();

            // Hierarchy
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedTinyInteger('depth')->default(1); // 1 = root, 2 = child, 3 = sub-child

            // Navigation
            $table->boolean('show_in_nav')->default(false);
            $table->integer('nav_order')->default(0);

            // General ordering
            $table->integer('order')->default(0);

            // Marketing / Homepage
            $table->boolean('is_featured')->default(false);

            // System
            $table->boolean('is_active')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');

            // Indexes
            $table->index('is_active');
            $table->index('slug');
            $table->index('parent_id');
            $table->index('depth');
            $table->index(['is_active', 'parent_id']);
            $table->index(['show_in_nav', 'nav_order']);
            $table->index(['parent_id', 'is_active']);
            $table->index(['is_active', 'depth']);
            $table->index(['is_active', 'is_featured']);
            $table->index(['parent_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
