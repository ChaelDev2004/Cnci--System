<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PageVisit extends Model
{
    protected $fillable = [
        'page',
        'ip_address',
        'user_agent',
        'session_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public static function tableReady(): bool
    {
        try {
            if (Schema::hasTable('page_visits')) {
                return true;
            }

            Schema::create('page_visits', function (Blueprint $table) {
                $table->id();
                $table->string('page')->default('welcome');
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent', 500)->nullable();
                $table->string('session_id', 100)->nullable()->index();
                $table->boolean('is_read')->default(false)->index();
                $table->timestamps();
                $table->index(['page', 'created_at']);
            });

            return Schema::hasTable('page_visits');
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Record a public page visit once per browser session.
     * Skips authenticated admins so dashboard previews do not inflate counts.
     */
    public static function track(Request $request, string $page = 'welcome'): void
    {
        if (! static::tableReady()) {
            return;
        }

        if (Auth::check()) {
            return;
        }

        $sessionKey = 'page_visit_tracked_' . $page;
        if ($request->session()->has($sessionKey)) {
            return;
        }

        try {
            static::create([
                'page' => $page,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'session_id' => $request->session()->getId(),
                'is_read' => false,
            ]);
            $request->session()->put($sessionKey, true);
        } catch (\Throwable $e) {
            // Ignore tracking failures so the public page still loads.
        }
    }
}
