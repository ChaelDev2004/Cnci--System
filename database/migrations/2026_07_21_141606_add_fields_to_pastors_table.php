<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pastors', function (Blueprint $table) {
            // Add new fields for pastor detail page
            $table->text('bio')->nullable()->after('church');
            $table->string('email')->nullable()->after('bio');
            $table->string('phone')->nullable()->after('email');
            $table->string('facebook')->nullable()->after('phone');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('youtube')->nullable()->after('instagram');
        });
    }

    public function down()
    {
        Schema::table('pastors', function (Blueprint $table) {
            $table->dropColumn(['bio', 'email', 'phone', 'facebook', 'instagram', 'youtube']);
        });
    }
};
