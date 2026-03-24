<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Make $categories and $brands available in all views
        View::composer('*', function ($view) {
            $categories = Category::all();

            $brands = Product::whereNotNull('brand')
                        ->select('brand')
                        ->distinct()
                        ->orderBy('brand')
                        ->get()
                        ->pluck('brand'); // just get array of brand names

            $view->with([
                'categories' => $categories,
                'brands'     => $brands,
            ]);
        });
    }
}
