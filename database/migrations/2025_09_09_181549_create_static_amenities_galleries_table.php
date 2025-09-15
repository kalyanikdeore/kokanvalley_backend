<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('static_amenities_galleries', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Stores both English and Marathi titles
            $table->json('description'); // Stores both English and Marathi descriptions
            $table->json('images'); // Stores array of image paths
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('static_amenities_galleries');
    }
};