<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('church_locations', function (Blueprint $table) {
            // Change maps_link to text to handle long URLs
            $table->text('maps_link')->nullable()->change();

            // Also make map_embed_url text if it's not already
            $table->text('map_embed_url')->change();

            // Change visit_link to text
            $table->text('visit_link')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('church_locations', function (Blueprint $table) {
            $table->string('maps_link', 500)->nullable()->change();
            $table->string('map_embed_url', 500)->change();
            $table->string('visit_link', 255)->nullable()->change();
        });
    }
};
