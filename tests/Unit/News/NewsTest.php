<?php

namespace Tests\Unit\News;

use App\Models\News;
use CyrildeWit\EloquentViewable\Contracts\Views;
use Tests\TestCase;

class NewsTest extends TestCase
{
    public function test_it_compute_is_published_attribute_correctly_when_news_is_published()
    {
        $news = News::factory()->create([
            'date' => now()->subDay()
        ]);

        $this->assertTrue($news->is_published);
    }

    public function test_it_compute_is_published_attribute_correctly_when_news_is_not_published()
    {
        $news = News::factory()->create([
            'date' => now()->addDay()
        ]);

        $this->assertFalse($news->is_published);
    }

    public function test_news_has_views_count()
    {
        $news = News::factory()->create();

        $this->assertInstanceOf(Views::class, views($news));
    }

    public function test_it_remove_views_on_delete()
    {
        $news = News::factory()->create();

        views($news)->record();

        $this->assertDatabaseHas('views', ['viewable_id' => $news->id]);

        $news->delete();

        $this->assertDatabaseMissing('views', ['viewable_id' => $news->id]);
    }
}
