<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('church_locations', function (Blueprint $table) {
            // Add pastor_id foreign key
            $table->foreignId('pastor_id')->nullable()->after('sort_order')->constrained()->onDelete('set null');
            // Add visit_link for custom pastor page
            $table->string('visit_link')->nullable()->after('pastor_id');
        });
    }

    public function down()
    {
        Schema::table('church_locations', function (Blueprint $table) {
            $table->dropForeign(['pastor_id']);
            $table->dropColumn(['pastor_id', 'visit_link']);
        });
    }
};
