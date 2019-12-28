<?php

namespace Tests\Feature\Home;

use App\Article;
use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeShowTest extends TestCase
{
    /** @test */
    public function it_award_achievement_when_article_written()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->state('admin')->create();
        dd($user->is_admin);

        $this->actingAs($user);

        $this->get('/home')->assertOk();
    }
}
