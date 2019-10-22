<?php

namespace Tests\Feature\Article;

use App\Article;
use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleStoreTest extends TestCase
{
    /** @test */
    public function it_award_achievement_when_article_written()
    {
        $user = factory(User::class)->create([
            'is_admin' => true
        ]);

        $this->actingAs($user);

        $this->post('/article', [
            'title' => 'How to fight with aliens',
            'body' => 'If you see aliens take a phone, start a record and run away',
            'month' => '2019-09'
        ]);

        $this->put('/article/1/publish');

        $this->assertCount(1, $user->achievements);
    }

    /** @test */
    public function it_award_achievements_when_10_articles_written()
    {
        $user = factory(User::class)->create([
            'is_admin' => true
        ]);

        $this->actingAs($user);

        for ($i = 1; $i <= 10; $i++) {
            $this->post('/article', [
                'title' => 'How to fight with aliens',
                'body' => 'If you see aliens take a phone, start a record and run away',
                'month' => '2019-09'
            ]);

            $this->put('/article/' . $i .'/publish');
        }

        $this->assertCount(2, $user->achievements);
    }
}
