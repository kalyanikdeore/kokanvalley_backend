<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_kokan_valleys', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('story');
            $table->string('image1_url');
            $table->string('image2_url');
            $table->string('video_url')->nullable();
            $table->json('watch_story_text');
            $table->json('overlap_image_alt');
            $table->string('founder_image_url')->nullable();
            $table->string('founder_name')->nullable();
            $table->string('founder_position')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_kokan_valleys');
    }
};