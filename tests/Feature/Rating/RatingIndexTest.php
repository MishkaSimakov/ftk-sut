<?php

namespace Tests\Feature\Rating;

use App\Imports\PointsRatingImport;
use Carbon\Carbon;
use Database\Seeders\RatingSeeder;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class RatingIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RatingSeeder::class);
        $this->loadRating();
    }

    public function test_it_create_students()
    {
        $this->assertDatabaseCount('users', 140);
    }

    public function test_it_get_last_points_period_correctly()
    {
        $this->json('GET', route('api.rating.show'))
            ->assertJsonFragment([
                'start' => '2020-01',
                'end' => '2020-01'
            ]);
    }

    public function test_it_returns_rating_in_right_format()
    {
        $this->json('GET', route('api.rating.show'))
            ->assertJsonStructure([
                'rating',
                'categories',
                'meta'
            ]);
    }

    public function test_it_count_rating_total_right()
    {
        $this->json('GET', route('api.rating.show'))
            ->assertJsonFragment([
                'name' => 'Абольянин Павел'
            ]);
    }

    public function loadRating()
    {
        $rating = storage_path('app/testing/rating_many_lists.xls');

        Excel::import(new PointsRatingImport(Carbon::parse('2020-01')), $rating);
    }
}
