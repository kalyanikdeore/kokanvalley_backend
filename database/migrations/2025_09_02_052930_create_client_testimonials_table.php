// database/migrations/xxxx_xx_xx_xxxxxx_create_client_testimonials_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('client_testimonials', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('role');
            $table->json('location');
            $table->json('content');
            $table->integer('rating');
            $table->integer('project_id');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_testimonials');
    }
};