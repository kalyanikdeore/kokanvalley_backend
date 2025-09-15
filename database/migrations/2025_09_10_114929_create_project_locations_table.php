<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->text('address_en')->nullable();
            $table->text('address_mr')->nullable();
            $table->text('embed_url')->nullable();
            $table->integer('zoom_level')->default(15);
            $table->string('map_type')->default('roadmap');
            $table->timestamps();
            
            $table->unique('project_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_locations');
    }
};