<?php
// database/migrations/[timestamp]_create_core_values_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('core_values', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->json('title'); // For multilingual titles
            $table->json('description'); // For multilingual descriptions
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('core_values');
    }
};