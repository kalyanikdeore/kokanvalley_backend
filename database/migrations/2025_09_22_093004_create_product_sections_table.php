<?php
// database/migrations/xxxx_xx_xx_create_product_sections_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_sections', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // For bilingual support
            $table->string('slug')->unique();
            $table->json('description')->nullable(); // For bilingual support
            $table->string('image');
            $table->json('category'); // For bilingual support
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_sections');
    }
};