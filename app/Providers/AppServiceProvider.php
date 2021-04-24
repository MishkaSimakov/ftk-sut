<?php

namespace App\Providers;

use App\Models\RatingPointCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        HeadingRowFormatter::extend('rating', function($value) {
            return optional(RatingPointCategory::where('import_name', $value)->first())->slug;
        });

        HeadingRowFormatter::default('rating');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
