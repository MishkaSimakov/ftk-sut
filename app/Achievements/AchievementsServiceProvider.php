<?php

namespace App\Achievements;

use App\Achievements\Console\GenerateAchievementCommand;
use App\Achievements\Types\Get1000PointsInMonthRating;
use App\Achievements\Types\GetLessThen250PointsInMonthRating;
use App\Achievements\Types\Write10Articles;
use App\Achievements\Types\WriteFirstArticle;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class AchievementsServiceProvider extends ServiceProvider
{
    protected $achievements = [
        'points' => [
            Get1000PointsInMonthRating::class,
            GetLessThen250PointsInMonthRating::class,
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
            $array = [];

            foreach ($this->achievements as $key => $achievementCategory) {
                $array = Arr::add($array, $key,
                    collect($achievementCategory)->map(function ($achievement) {
                        return new $achievement;
                    })
                );
            }

            return $array;
        });

        $this->commands(GenerateAchievementCommand::class);
    }
}
