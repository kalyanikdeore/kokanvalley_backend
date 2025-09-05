<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_amenities', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Stores titles in multiple languages
            $table->json('description'); // Stores descriptions in multiple languages
            $table->json('images'); // Stores array of image paths
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_amenities');
    }
};