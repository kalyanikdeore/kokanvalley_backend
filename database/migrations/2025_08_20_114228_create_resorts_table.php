<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_resorts_table.php
public function up()
{
    Schema::create('resorts', function (Blueprint $table) {
        $table->id();
        $table->json('title'); // For multilingual support
        $table->json('description'); // For multilingual support
        $table->string('image');
        $table->string('category');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resorts');
    }
};
