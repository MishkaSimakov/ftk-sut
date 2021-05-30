<?php

namespace App\Providers;

use App\Events\Article\ArticleFirstTimeChecked;
use App\Events\Article\ArticleLiked;
use App\Events\News\NewsCreated;
use App\Events\Rating\RatingCreated;
use App\Events\Rating\RatingDeleted;
use App\Listeners\Article\AwardArticlePointAchievements;
use App\Listeners\Article\AwardWriteArticleAchievements;
use App\Listeners\Article\SendArticleNotificationEmail;
use App\Listeners\News\SendNewsNotificationEmail;
use App\Listeners\Rating\AwardMonthlyRatingPointAchievements;
use App\Listeners\Rating\SendRatingNotificationEmail;
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
        ArticleFirstTimeChecked::class => [
            SendArticleNotificationEmail::class,
            AwardWriteArticleAchievements::class,
        ],
        ArticleLiked::class => [
            AwardArticlePointAchievements::class,
        ],
        RatingCreated::class => [
            AwardMonthlyRatingPointAchievements::class,
            SendRatingNotificationEmail::class,
        ],
        RatingDeleted::class => [
            AwardMonthlyRatingPointAchievements::class,
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
