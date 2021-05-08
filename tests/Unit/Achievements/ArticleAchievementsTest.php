<?php

namespace Tests\Unit\Achievements;

use App\Achievements\Articles\Write10Articles;
use App\Achievements\Articles\WriteFirstArticle;
use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticleAchievementsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        auth()->login($user);
    }

    public function test_it_award_article_write_achievement_when_article_is_published()
    {
        auth()->user()->articles()->saveMany(
            Article::factory()->count(10)->make([
                'type' => ArticleType::OnCheck()
            ])
        )->each->publish();

        $this->assertEquals(true, auth()->user()->achievementStatus(new Write10Articles())->isUnlocked());
        $this->assertEquals(true, auth()->user()->achievementStatus(new WriteFirstArticle())->isUnlocked());
    }

    public function test_it_doesnt_award_write_achievements_when_articles_count_not_enough()
    {
        auth()->user()->articles()->saveMany(
            Article::factory()->count(9)->make([
                'type' => ArticleType::OnCheck()
            ])
        )->each->publish();

        $this->assertEquals(false, auth()->user()->achievementStatus(new Write10Articles())->isUnlocked());
        $this->assertEquals(true, auth()->user()->achievementStatus(new WriteFirstArticle())->isUnlocked());
    }

    public function test_it_doest_award_write_achievement_when_article_published_many_times()
    {
        $article = auth()->user()->articles()->save(
            Article::factory()->make([
                'type' => ArticleType::OnCheck()
            ])
        );

        for ($i = 0; $i <= 10; $i++) {
            $article->publish();
        }

        $this->assertEquals(false, auth()->user()->achievementStatus(new Write10Articles())->isUnlocked());
        $this->assertEquals(true, auth()->user()->achievementStatus(new WriteFirstArticle())->isUnlocked());
    }

    public function test_it_dont_count_unpublished_articles()
    {
        auth()->user()->articles()->saveMany(
            Article::factory()->count(10)->make([
                'type' => ArticleType::OnCheck()
            ])
        );

        $this->assertEquals(false, auth()->user()->achievementStatus(new Write10Articles())->isUnlocked());
        $this->assertEquals(false, auth()->user()->achievementStatus(new WriteFirstArticle())->isUnlocked());
    }
}
