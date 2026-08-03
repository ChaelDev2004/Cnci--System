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
        Schema::create('ministers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();    // e.g. "R1 Administrator"
            $table->string('subrole')->nullable(); // e.g. "R1 YPAP Coordinator"
            $table->string('image')->nullable();
            $table->enum('group', ['gospel_minister', 'region1_staff']);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ministers');
    }
};
