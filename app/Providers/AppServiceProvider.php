<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Settings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Paginator::useBootstrapFive(); bs5 kullanimi
        Paginator::defaultView("vendor.pagination.yazilimegitimPagination"); // default kullanma

        // projenin varsayilan dili
        Carbon::setLocale(config("app.locale"));

        // frontController da tekrarlanan kodlarin onune gecmek icin view share & view composer kullanimi
        View::composer(["front.*", "mail::header", "email.*", "layouts.admin.*"], function ($view) {
            $settings = Settings::first();
            $categories = Category::query()
                ->with('childCategories')
                ->where("status", 1)
                ->orderBy('order', 'DESC')
                ->get();

            $view->with("categories", $categories)->with("settings", $settings);
        });
    }
}