<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Teacher::class, function (Faker $faker) {
    return [
//        'job_title' => $faker->jobTitle,
        'avatar' => $faker->imageUrl(),
    ];
});
