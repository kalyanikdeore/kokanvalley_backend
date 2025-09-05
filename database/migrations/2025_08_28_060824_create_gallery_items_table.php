<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_xxxxxx_create_gallery_items_table.php
public function up()
{
    Schema::create('gallery_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('gallery_categories')->onDelete('cascade');
        $table->json('title'); // For multilingual support
        $table->text('image_path');
        $table->integer('sort_order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
