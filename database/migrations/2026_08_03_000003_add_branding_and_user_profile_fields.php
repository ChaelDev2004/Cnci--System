<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('home_settings', 'brand_name')) {
                $table->string('brand_name')->nullable()->after('contact_website');
            }
            if (!Schema::hasColumn('home_settings', 'brand_tagline')) {
                $table->string('brand_tagline')->nullable()->after('brand_name');
            }
            if (!Schema::hasColumn('home_settings', 'logo_path')) {
                $table->string('logo_path')->nullable()->after('brand_tagline');
            }
            if (!Schema::hasColumn('home_settings', 'favicon_path')) {
                $table->string('favicon_path')->nullable()->after('logo_path');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('avatar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            foreach (['brand_name', 'brand_tagline', 'logo_path', 'favicon_path'] as $column) {
                if (Schema::hasColumn('home_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('users', function (Blueprint $table) {
            foreach (['avatar', 'phone'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
