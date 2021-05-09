<?php

namespace App\Providers;

use App\Events\ArticleFirstTimePublished;
use App\Events\ArticleLiked;
use App\Events\NewsCreated;
use App\Events\RatingCreated;
use App\Listeners\Articles\AwardArticlePointAchievements;
use App\Listeners\Articles\AwardWriteArticleAchievements;
use App\Listeners\Articles\SendArticleNotificationEmail;
use App\Listeners\News\SendNewsNotificationEmail;
use App\Listeners\RatingPoints\AwardRatingPointAchievements;
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

        NewsCreated::class => [
            SendNewsNotificationEmail::class,
        ],
        ArticleFirstTimePublished::class => [
            SendArticleNotificationEmail::class,
            AwardWriteArticleAchievements::class,
        ],
        ArticleLiked::class => [
            AwardArticlePointAchievements::class,
        ],
        RatingCreated::class => [
            AwardRatingPointAchievements::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
