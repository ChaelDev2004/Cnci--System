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
        Schema::create('church_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('address');
            $table->text('map_embed_url');
            $table->string('maps_link')->nullable();
            $table->string('service_time')->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_locations');
    }
};
