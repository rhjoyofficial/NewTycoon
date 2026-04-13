<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();                // internal name (e.g., "Homepage New Arrivals")
            $table->string('title_en')->default('');
            $table->string('title_bn')->nullable();
            $table->string('type');                             // 'product_slider' or 'banner'
            $table->integer('order')->default(0);               // sort order
            $table->boolean('is_active')->default(true);
            $table->foreignId('ad_banner_id')->nullable()->constrained()->nullOnDelete();
            $table->json('settings')->nullable();               // additional config (product_type, slidesPerView, autoPlay, etc.)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
