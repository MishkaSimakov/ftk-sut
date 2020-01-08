<?php

namespace App\Achievements;

use App\Achievements\Console\GenerateAchievementCommand;
use App\Achievements\Types\GetMoreThen1000PointsInRating;
use App\Achievements\Types\GetLessThen250PointsInRating;
use App\Achievements\Types\Write10Articles;
use App\Achievements\Types\WriteFirstArticle;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class AchievementsServiceProvider extends ServiceProvider
{
    protected $achievements = [
        'points' => [
            GetMoreThen1000PointsInRating::class,
            GetLessThen250PointsInRating::class,
        ],
        'articles' => [
            WriteFirstArticle::class,
            Write10Articles::class
        ]
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('achievements', function() {
            return collect($this->achievements)->transform(function ($item, $key) {
                return collect($item)->transform(function ($item) {
                    return new $item;
                });
            });
        });

        $this->commands(GenerateAchievementCommand::class);
    }
}
