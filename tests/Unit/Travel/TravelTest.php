<?php

namespace Tests\Unit\Travel;

use App\Schedule;
use App\Travel;
use App\User;
use Tests\TestCase;

class TravelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_create_travel()
    {
        $travel = factory(Travel::class)->create([
            'schedule_id' => factory(Schedule::class)->create()->id,
            'distance' => 123,
            'is_bike' => false,
        ]);

        $this->assertInstanceOf(Travel::class, $travel);
        $this->assertInstanceOf(Schedule::class, $travel->schedule);
    }

    public function test_it_can_has_users()
    {
        $travel = factory(Travel::class)->create([
            'schedule_id' => null,
            'distance' => 123,
            'is_bike' => false,
        ]);

        $travel->users()->save(
            factory(User::class)->create(),
            [
                'distance' => 123
            ]
        );

        $this->assertInstanceOf(User::class, $travel->users->first());
    }
}
