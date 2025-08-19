<?php
// database/migrations/xxxx_xx_xx_create_testimonials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // Store multilingual names
            $table->json('role'); // Store multilingual roles
            $table->json('location'); // Store multilingual locations
            $table->json('content'); // Store multilingual content
            $table->integer('rating');
            $table->integer('project_id');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
};