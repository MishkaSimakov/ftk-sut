<?php

namespace App\Providers;

use App\Achievements\Events\UserEarnedPoints;
use App\Achievements\Events\UserLikeArticle;
use App\Achievements\Events\UserWriteArticle;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        //achievements
        UserEarnedPoints::class => [
            \App\Achievements\Listeners\AwardPointAchievements::class,
        ],
        UserLikeArticle::class => [
            \App\Achievements\Listeners\AwardArticleAchievements::class,
        ],
        UserWriteArticle::class => [
            \App\Achievements\Listeners\AwardArticleAchievements::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
