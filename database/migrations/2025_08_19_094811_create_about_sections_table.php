<?php
// database/migrations/[timestamp]_create_about_sections_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            
            // Title fields
            $table->string('title_en');
            $table->string('title_mr');
            
            // Subtitle fields
            $table->string('subtitle_en');
            $table->string('subtitle_mr');
            
            // Description fields
            $table->text('description_en');
            $table->text('description_mr');
            
            // Stats fields
            $table->json('stats'); // Will store all stats as JSON
            
            // Image labels
            $table->json('image_labels');
            
            // Image paths
            $table->string('image_beach');
            $table->string('image_hills');
            $table->string('image_cuisine');
            $table->string('image_villages');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_sections');
    }
};