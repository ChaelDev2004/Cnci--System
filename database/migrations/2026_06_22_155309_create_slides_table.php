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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->enum('bg_type', ['image', 'video', 'color'])->default('image');
            $table->string('bg_image')->nullable();
            $table->string('bg_video_url')->nullable();
            $table->string('eyebrow')->nullable();
            $table->string('heading')->nullable();
            $table->text('subtext')->nullable();
            $table->string('cta_primary_label')->nullable();
            $table->string('cta_primary_link')->nullable();
            $table->text('testimonial')->nullable();
            $table->string('service_badge')->nullable(); // e.g. "9:00 AM & 11:00 AM"
            $table->enum('layout', ['default', 'welcome', 'plain'])->default('default');
            $table->boolean('active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
