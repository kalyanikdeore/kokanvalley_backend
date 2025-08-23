<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('video_url');
            $table->string('title_en');
            $table->string('title_mr');
            $table->text('description_en');
            $table->text('description_mr');
            $table->string('youtube_link')->nullable();
            $table->string('cta_highlight_en')->nullable();
            $table->string('cta_highlight_mr')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_sections');
    }
};