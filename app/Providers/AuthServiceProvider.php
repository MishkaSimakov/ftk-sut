<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Event;
use App\Models\News;
use App\Models\RatingPoint;
use App\Policies\ArticlePolicy;
use App\Policies\EventPolicy;
use App\Policies\NewsPolicy;
use App\Policies\RatingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        News::class => NewsPolicy::class,
        Event::class => EventPolicy::class,
        RatingPoint::class => RatingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
