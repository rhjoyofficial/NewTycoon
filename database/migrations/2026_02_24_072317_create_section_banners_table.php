<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('section_banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_banner_id')->constrained('ad_banners')->onDelete('cascade');
            $table->integer('order')->default(0);      // order among banners in a pure banner section
            $table->integer('position')->nullable();   // for product sliders: after which product (0-indexed) this banner appears; null = end
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section_banners');
    }
};
