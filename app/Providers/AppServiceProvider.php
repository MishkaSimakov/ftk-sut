<?php

namespace App\Providers;

use App\Models\RatingPointCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        Blade::if('admin', function () {
            return auth()->check() and auth()->user()->is_admin;
        });


        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        HeadingRowFormatter::extend('rating', function($value) {
            return optional(RatingPointCategory::whereHas('importNames', function (Builder $builder) use ($value) {
                $builder->where('import_name', $value);
            })->first())->slug;
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
