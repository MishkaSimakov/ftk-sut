<?php

namespace Tests\Unit\Articles;

use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\ArticlePoint;
use App\Models\User;
use CyrildeWit\EloquentViewable\Contracts\Views;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    public function test_it_compute_is_published_attribute_correctly_when_article_is_published()
    {
        $article = Article::factory()->create([
            'date' => now()->subDay()
        ]);

        $this->assertTrue($article->is_published);
    }

    public function test_it_compute_is_published_attribute_correctly_when_article_is_not_published()
    {
        $article = Article::factory()->create([
            'date' => now()->addDay()
        ]);

        $this->assertFalse($article->is_published);
    }

    public function test_article_has_views_count()
    {
        $article = Article::factory()->create();

        $this->assertInstanceOf(Views::class, views($article));
    }

    public function test_it_remove_views_on_delete()
    {
        $article = Article::factory()->create();

        views($article)->record();

        $this->assertDatabaseHas('views', ['viewable_id' => $article->id]);

        $article->delete();

        $this->assertDatabaseMissing('views', ['viewable_id' => $article->id]);
    }

    public function test_it_has_points()
    {
        $article = Article::factory()->create();
        $user = User::factory()->create();

        $article->toggleLikeBy($user);

        $this->assertInstanceOf(User::class, $article->points->first());
    }

    public function test_it_has_type()
    {
        $article = Article::factory()->create();

        $this->assertInstanceOf(ArticleType::class, $article->type);
    }

    public function it_can_be_checked()
    {
        $article = Article::factory()->create([
            'type' => ArticleType::OnCheck
        ]);

        $article->check();

        $this->assertEquals(ArticleType::Checked, $article->type);
    }
}
