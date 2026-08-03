<?php

namespace App\Providers;

use App\Models\HomeSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            static $siteSettings = null;

            if ($siteSettings === null) {
                try {
                    $siteSettings = HomeSettings::first() ?? new HomeSettings();
                } catch (\Throwable $e) {
                    $siteSettings = new HomeSettings();
                }
            }

            $view->with('siteSettings', $siteSettings);
        });
    }
}
