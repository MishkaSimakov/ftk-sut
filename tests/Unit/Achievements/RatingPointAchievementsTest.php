<?php

namespace Tests\Unit\Achievements;

use App\Achievements\Rating\Monthly\GetMoreThan10000RatingPoints;
use App\Achievements\Rating\Monthly\GetMoreThan1000RatingPoints;
use App\Models\User;
use App\Services\RatingService;
use Carbon\Carbon;
use Database\Seeders\RatingPointCategorySeeder;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RatingPointAchievementsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RatingPointCategorySeeder::class);
    }

    public function test_it_award_points_achievements()
    {
        $path = storage_path('app/testing/rating_many_lists.xls');

        (new RatingService())->storeRating(
            Carbon::parse('2020-01'),
            new UploadedFile($path, 'rating.xls', 'application/vnd.ms-excel', null, true)
        );

        $this->assertTrue(User::where('name', 'Агапитов Савелий')->first()->achievementStatus(new GetMoreThan1000RatingPoints())->isUnlocked());
        $this->assertTrue(User::where('name', 'Вардоев Максим')->first()->achievementStatus(new GetMoreThan10000RatingPoints())->isUnlocked());
    }

    public function test_it()
    {
        
    }
}
