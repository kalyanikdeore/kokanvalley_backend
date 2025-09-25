<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_footer_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->json('brand_name')->nullable(); // {en: '', mr: ''}
            $table->json('brand_description')->nullable();
            $table->json('address')->nullable(); // Multiple addresses
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('quick_links')->nullable();
            $table->json('newsletter_text')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('footer_settings');
    }
};