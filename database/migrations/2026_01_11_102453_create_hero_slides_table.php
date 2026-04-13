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
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('background');

            $table->boolean('has_content')->default(false);
            $table->enum('content_position', ['left', 'right', 'center'])->default('center');

            $table->string('badge_en')->nullable();
            $table->string('badge_bn')->nullable();

            $table->text('title_en')->nullable();
            $table->text('title_bn')->nullable();

            $table->text('subtitle_en')->nullable();
            $table->text('subtitle_bn')->nullable();

            $table->boolean('has_cta')->default(false);
            $table->json('cta_buttons')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->enum('device', ['all', 'mobile', 'desktop'])->default('all');
            $table->integer('clicks_count')->default(0);
            $table->integer('views_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
