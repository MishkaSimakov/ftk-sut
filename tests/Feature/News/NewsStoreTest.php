<?php

namespace Tests\Feature\News;

use App\Models\News;
use App\Models\User;
use Tests\TestCase;

class NewsStoreTest extends TestCase
{
    public function test_it_dont_store_news_if_unauthenticated()
    {
        $this->json('POST', route('news.store'))
            ->assertStatus(403);
    }

    public function test_it_dont_store_news_if_not_admin()
    {
        $user = User::factory()->create();
        auth()->login($user);

        $this->json('POST', route('news.store'))
            ->assertStatus(403);
    }

    public function test_it_store_news()
    {
        $user = User::factory()->admin()->create();
        auth()->login($user);

        $this->json('POST', route('news.store'), [
            'title' => 'Title',
            'body' => '123',
        ])
            ->assertRedirect(route('news.index'));

        $this->assertDatabaseCount('news', 1);
    }

    public function test_it_store_news_with_correct_date_if_delayed_publication()
    {
        $user = User::factory()->admin()->create();
        auth()->login($user);

        $this->json('POST', route('news.store'), [
            'title' => 'Title',
            'body' => '123',
            'delayed_publication' => 'on',
            'date' => $date = now()->addDay()
        ])
            ->assertRedirect(route('news.index'));

        $this->assertEquals($date, News::first()->date);
    }
}
