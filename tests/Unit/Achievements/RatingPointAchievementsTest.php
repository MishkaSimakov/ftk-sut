<?php

namespace Tests\Unit\Achievements;

use App\Achievements\Rating\Monthly\GetMoreThan10000RatingPoints;
use App\Achievements\Rating\Monthly\GetMoreThan1000RatingPoints;
use App\Achievements\Rating\Monthly\TakeFirstPlace;
use App\Achievements\Rating\Monthly\TakeSecondPlace;
use App\Achievements\Rating\Monthly\TakeThirdPlace;
use App\Models\User;
use App\Services\Rating\Rating;
use Carbon\Carbon;
use Database\Seeders\RatingSeeder;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RatingPointAchievementsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RatingSeeder::class);

        $this->storeRating(
            Carbon::parse('2020-01')
        );
    }

    public function test_it_award_points_achievements()
    {
        $this->assertTrue(User::where('name', 'Агапитов Савелий')->first()->achievementStatus(new GetMoreThan1000RatingPoints())->isUnlocked());
        $this->assertTrue(User::where('name', 'Вардоев Максим')->first()->achievementStatus(new GetMoreThan10000RatingPoints())->isUnlocked());
    }

    public function test_it_dont_award_unnecessary_achievements()
    {
        $this->assertFalse(User::where('name', 'Агапитов Савелий')->first()->achievementStatus(new GetMoreThan10000RatingPoints())->isUnlocked());
    }

    public function test_it_dont_award_achievements_when_rating_loaded_many_times()
    {
        $this->storeRating(
            Carbon::parse('2020-02')
        );
        $this->storeRating(
            Carbon::parse('2020-03')
        );

        $testing_user = User::where('name', 'Дубяга Данил')->first();

        $this->assertTrue($testing_user->achievementStatus(new GetMoreThan1000RatingPoints())->isUnlocked());
        $this->assertFalse($testing_user->achievementStatus(new GetMoreThan10000RatingPoints())->isUnlocked());
        $this->assertEquals(7270, $testing_user->achievementStatus(new GetMoreThan10000RatingPoints())->points);
    }

    public function test_it_award_place_achievements_correctly()
    {
        $this->assertTrue(User::where('name', 'Боровой Павел')->first()->achievementStatus(new TakeFirstPlace())->isUnlocked());
        $this->assertTrue(User::where('name', 'Вардоев Максим')->first()->achievementStatus(new TakeSecondPlace())->isUnlocked());
        $this->assertTrue(User::where('name', 'Шумская Полина')->first()->achievementStatus(new TakeThirdPlace())->isUnlocked());

        $this->assertFalse(User::where('name', 'Вальдер Юрий')->first()->achievementStatus(new TakeFirstPlace())->isUnlocked());
    }

    protected function storeRating(Carbon $date)
    {
        $path = storage_path('app/testing/rating_many_lists.xls');
        (new Rating())->store(
            $date,
            new UploadedFile($path, 'rating.xls', 'application/vnd.ms-excel', null, true)
        );
    }
}
