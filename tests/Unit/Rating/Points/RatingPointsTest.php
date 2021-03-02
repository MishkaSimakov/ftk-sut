<?php

namespace Tests\Unit\Rating\Points;

use App\Models\RatingPoint;
use Carbon\CarbonPeriod;
use Tests\TestCase;

class RatingPointsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_scope_from_time_works()
    {
        $this->seed();

        $points = RatingPoint::fromTime(CarbonPeriod::create('2018-04', '2020-05'))->get();

        $this->assertTrue(true);
    }
}
