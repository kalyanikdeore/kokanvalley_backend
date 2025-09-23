<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('amenities_sections', function (Blueprint $table) {
        $table->id();
        $table->string('title_en');
        $table->string('title_mr');
        $table->text('description_en')->nullable();
        $table->text('description_mr')->nullable();
        $table->string('icon')->nullable();
        $table->json('images')->nullable(); // ✅ Store multiple images in JSON
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities_sections');
    }
};
