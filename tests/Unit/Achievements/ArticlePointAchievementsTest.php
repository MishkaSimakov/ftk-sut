<?php

namespace Tests\Unit\Achievements;

use App\Achievements\Articles\Points\LikeSelfArticle;
use App\Achievements\Articles\Points\Set10Likes;
use App\Achievements\Articles\Points\SetFirstLike;
use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticlePointAchievementsTest extends TestCase
{
    protected User $liker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        auth()->login($user);

        $this->liker = User::factory()->create();
    }

    public function test_it_award_article_points_achievements_when_it_needed()
    {
        $article = auth()->user()->articles()->save(
            Article::factory()->make()
        );

        $article->toggleLikeBy(auth()->user());

        $this->assertEquals(true, auth()->user()->achievementStatus(new LikeSelfArticle())->isUnlocked());
        $this->assertEquals(true, auth()->user()->achievementStatus(new SetFirstLike())->isUnlocked());
    }

    public function test_it_dont_award_like_self_article_when_it_not_needed()
    {
        $article = auth()->user()->articles()->save(
            Article::factory()->make()
        );

        $article->toggleLikeBy($this->liker);

        $this->assertEquals(false, auth()->user()->achievementStatus(new LikeSelfArticle())->isUnlocked());
    }

    public function test_it_award_like_10_articles_achievement()
    {
        auth()->user()->articles()->saveMany(
            Article::factory()->count(10)->make()
        )->each->toggleLikeBy(auth()->user());

        $this->assertEquals(true, auth()->user()->achievementStatus(new LikeSelfArticle())->isUnlocked());
        $this->assertEquals(true, auth()->user()->achievementStatus(new SetFirstLike())->isUnlocked());
        $this->assertEquals(true, auth()->user()->achievementStatus(new Set10Likes())->isUnlocked());
    }

    public function test_it_dont_award_achievements_when_like_one_article_multiple_times()
    {
        ($article = auth()->user()->articles()->save(
            Article::factory()->make()
        ))->toggleLikeBy(auth()->user());

        for ($i = 0; $i <= 20; $i++) {
            $article->toggleLikeBy(auth()->user());
        }

        $this->assertEquals(false, auth()->user()->achievementStatus(new Set10Likes())->isUnlocked());
    }
}
