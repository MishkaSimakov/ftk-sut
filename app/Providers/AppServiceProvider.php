<?php

namespace App\Providers;

use App\Console\Commands\Reset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function () {
            if (Auth::user()) {
                return Auth::user()->is_admin;
            }
        });

        Blade::if('student', function () {
            if (Auth::user()) {
                return Auth::user()->student->exists();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
