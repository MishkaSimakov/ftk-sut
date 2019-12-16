<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Schedule::class, function (Faker $faker) {
    return [
        'people_count' => 0,
        'date_start' => $faker->dateTimeBetween('-1 week', '+1 month'),
        'date_end' => $faker->dateTimeBetween('-1 week', '+1 month'),
        'title' => $faker->words(4, true)
    ];
});
