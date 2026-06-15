<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Page;
use App\Models\Category;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share static pages with the admin layout sidebar
        View::composer('layouts.admin', function ($view) {
            if (Schema::hasTable('pages')) {
                $view->with('adminPages', Page::orderBy('title')->get());
            }
        });

        // Share global data with the storefront layout and views
        View::composer(['layouts.storefront', 'storefront.*'], function ($view) {
            if (Schema::hasTable('categories') && Schema::hasTable('settings')) {
                if (! $view->offsetExists('globalCategories')) {
                    $view->with('globalCategories', Category::orderBy('name')->get());
                }
                if (! $view->offsetExists('globalSettings')) {
                    $view->with('globalSettings', Setting::pluck('value', 'key')->toArray());
                }
            }
        });
    }
}
