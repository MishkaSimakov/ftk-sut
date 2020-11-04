<?php

namespace Tests\Unit;


use App\Models\Club;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testItHasTitle()
    {
        $news = News::factory()->create();

        $this->assertArrayHasKey('title', $news->getAttributes());
    }

    public function testItHasBody()
    {
        $news = News::factory()->create();

        $this->assertArrayHasKey('body', $news->getAttributes());
    }

    public function testItHasClubs()
    {
        $news = News::factory()->create();
        $clubs = Club::all();

        $news->clubs()->sync($clubs);

        $this->assertInstanceOf(Club::class, $news->clubs->first());
    }

    public function testItHasClubScope()
    {
        $news = News::factory()->count(100)->create();
        $club = Club::all()->first();

        $news->slice(0, 10)->each(function ($news) use ($club) {
            $news->clubs()->sync($club);
        });

        $this->assertEquals(
            $news->slice(0, 10)->pluck('id'),
            News::club($club)->get()->pluck('id')
        );

        $this->assertEquals(
            $news->slice(0, 10)->pluck('id'),
            News::club($club->name)->get()->pluck('id')
        );
    }
}
