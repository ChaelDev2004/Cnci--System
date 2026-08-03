<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if pastor_id column exists before adding
        if (!Schema::hasColumn('church_locations', 'pastor_id')) {
            Schema::table('church_locations', function (Blueprint $table) {
                $table->foreignId('pastor_id')->nullable()->after('sort_order')->constrained()->onDelete('set null');
            });
        }

        if (!Schema::hasColumn('church_locations', 'visit_link')) {
            Schema::table('church_locations', function (Blueprint $table) {
                $table->string('visit_link')->nullable()->after('pastor_id');
            });
        }

        // Add pastor fields if they don't exist
        $pastorColumns = ['bio', 'email', 'phone', 'facebook', 'instagram', 'youtube'];
        foreach ($pastorColumns as $column) {
            if (!Schema::hasColumn('pastors', $column)) {
                Schema::table('pastors', function (Blueprint $table) use ($column) {
                    if ($column === 'bio') {
                        $table->text($column)->nullable()->after('church');
                    } elseif ($column === 'email') {
                        $table->string($column)->nullable()->after('bio');
                    } elseif ($column === 'phone') {
                        $table->string($column)->nullable()->after('email');
                    } elseif ($column === 'facebook') {
                        $table->string($column)->nullable()->after('phone');
                    } elseif ($column === 'instagram') {
                        $table->string($column)->nullable()->after('facebook');
                    } elseif ($column === 'youtube') {
                        $table->string($column)->nullable()->after('instagram');
                    }
                });
            }
        }
    }

    public function down()
    {
        // Remove columns safely
        if (Schema::hasColumn('church_locations', 'pastor_id')) {
            Schema::table('church_locations', function (Blueprint $table) {
                $table->dropForeign(['pastor_id']);
                $table->dropColumn('pastor_id');
            });
        }

        if (Schema::hasColumn('church_locations', 'visit_link')) {
            Schema::table('church_locations', function (Blueprint $table) {
                $table->dropColumn('visit_link');
            });
        }

        $pastorColumns = ['bio', 'email', 'phone', 'facebook', 'instagram', 'youtube'];
        foreach ($pastorColumns as $column) {
            if (Schema::hasColumn('pastors', $column)) {
                Schema::table('pastors', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
