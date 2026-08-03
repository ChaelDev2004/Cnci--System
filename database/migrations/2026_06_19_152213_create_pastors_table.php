<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pastors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();   // e.g. "Int'l Mission Ambassador"
            $table->string('church');             // e.g. "CNCI Urdaneta I"
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastors');
    }
};
