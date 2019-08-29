<?php

use App\Achievement;
use Faker\Generator as Faker;

$factory->define(Achievement::class, function (Faker $faker) {
    return [
        'image_url' => $faker->imageUrl(),
    ];
});
