<?php

namespace Tests\Feature\Achievement;

use App\Achievement;
use App\Category;
use App\Rating;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AchievementEarnTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function user_can_earn_an_achievement()
    {
        $user = factory(User::class)->create();
        $achievement = factory(Achievement::class)->create();

        $achievement->awardTo($user);

        $this->assertCount(1, $user->achievements);
    }

    /** @test */
    public function user_get_achievement_when_earn_1000_points()
    {
        $user = factory(User::class)->create();
        $rating = factory(Rating::class)->create();
        $category = factory(Category::class)->create();

        $user->award($rating, $category->name, 1001);

        $this->assertCount(1, $user->achievements);
    }


}
