<?php

namespace App\Providers;

use App\Support\AdminMenuBuilder;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('layouts.sections.menu.*', function ($view) {
            try {
                $menu = AdminMenuBuilder::toMenuTree();
                $verticalMenuData = (object) ['menu' => $menu];
            } catch (\Throwable $e) {
                $json = file_get_contents(base_path('resources/menu/verticalMenu.json'));
                $verticalMenuData = json_decode($json) ?: (object) ['menu' => []];
            }

            $view->with('menuData', [$verticalMenuData]);
        });
    }
}
