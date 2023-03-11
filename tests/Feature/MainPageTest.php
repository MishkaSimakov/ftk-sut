<?php

namespace Tests\Feature;

use App\Enums\ArticleType;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MainPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_accessible()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_it_shows_article_count()
    {
        $response = $this->get('/');

        $response->assertViewHas('statistics', function ($statistics) {
            return $statistics['articles_count'] == 0;
        });

        $article = Article::factory()->create();

        $response->assertViewHas('statistics', function ($statistics) {
            return $statistics['articles_count'] == 1;
        });
    }
}
