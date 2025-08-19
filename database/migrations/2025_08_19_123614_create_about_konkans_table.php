<?php
// database/migrations/xxxx_xx_xx_create_about_konkans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_konkans', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // For storing multilingual titles
            $table->json('story'); // For storing multilingual stories
            $table->string('image1_url');
            $table->string('image2_url');
            $table->string('video_url')->nullable();
            $table->json('watch_story_text'); // For multilingual button text
            $table->json('overlap_image_alt'); // For multilingual alt text
            $table->string('founder_image_url')->nullable();
            $table->json('founder_name')->nullable(); // Multilingual founder name
            $table->json('founder_position')->nullable(); // Multilingual position
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_konkans');
    }
};