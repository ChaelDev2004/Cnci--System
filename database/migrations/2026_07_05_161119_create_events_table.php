// database/migrations/2026_01_15_create_events_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tag')->nullable(); // Weekly, Youth, Prayer, Conference, etc.
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->string('date')->nullable(); // "Every Sunday" or "June 12–14"
            $table->string('time')->nullable(); // "9:00 AM & 11:00 AM"
            $table->string('location')->nullable();
            $table->string('button_text')->default('Learn More');
            $table->string('button_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamp('event_date')->nullable(); // For sorting upcoming events
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
