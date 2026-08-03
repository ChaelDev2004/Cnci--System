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
        Schema::create('about_page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->string('hero_eyebrow')->nullable();
            $table->text('hero_subtext')->nullable();
            $table->text('story_paragraph_1')->nullable();
            $table->text('story_paragraph_2')->nullable();
            $table->string('story_image')->nullable();
            $table->string('hero_bg_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_page_contents');
    }
};
