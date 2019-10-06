<?php

namespace App\Achievements;

use App\Achievements\Console\GenerateAchievementCommand;
use App\Achievements\Types\Get1000PointsInMonthRating;
use Illuminate\Support\ServiceProvider;

class AchievementsServiceProvider extends ServiceProvider
{
    protected $achievements = [
        Get1000PointsInMonthRating::class,
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
            return collect($this->achievements)->map(function($achievement) {
                return new $achievement;
            });
        });

        $this->commands(GenerateAchievementCommand::class);
    }
}
