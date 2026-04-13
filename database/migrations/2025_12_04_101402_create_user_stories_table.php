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
        Schema::create('user_stories', function (Blueprint $table) {
            $table->id();

            // User
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_name')->nullable(); // Cache user name
            $table->string('user_avatar')->nullable(); // Cache user avatar

            // Product
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');

            // Content
            $table->string('video_path');
            $table->string('thumbnail')->nullable();
            $table->text('caption');
            $table->integer('duration')->default(15); // Duration in seconds

            // Engagement
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('shares_count')->default(0);

            // Moderation
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');

            // Reporting
            $table->integer('reports_count')->default(0);
            $table->timestamp('last_reported_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['is_approved', 'is_active', 'is_featured']);
            $table->index(['user_id', 'created_at']);
            $table->index(['product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_stories');
    }
};
