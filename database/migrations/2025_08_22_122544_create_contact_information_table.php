<?php
// database/migrations/xxxx_xx_xx_create_contact_informations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contact_informations', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->string('email');
            $table->json('addresses'); // Store multiple addresses as JSON
            $table->json('social_links'); // Store social media links as JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_informations');
    }
};