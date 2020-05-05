<?php

namespace Tests\Feature;

use App\Rating;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ViewRatingPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\CategorySeeder::class);
        $this->seed(\AchievementSeeder::class);
    }

    /** @test */
    public function user_can_view_rating_list()
    {
        $response = $this->get(route('rating.index'));

        $response->assertStatus(200);
    }
}
