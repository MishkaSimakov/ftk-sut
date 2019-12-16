<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Teacher::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->firstName,
        'job_title' => $faker->jobTitle,
        'avatar' => $faker->imageUrl(),
    ];
});
