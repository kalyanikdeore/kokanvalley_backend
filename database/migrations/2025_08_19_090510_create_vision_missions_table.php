<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vision_missions', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // For multilingual titles
            $table->json('vision_title');
            $table->json('vision_content');
            $table->json('mission_title');
            $table->json('mission_content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vision_missions');
    }
};