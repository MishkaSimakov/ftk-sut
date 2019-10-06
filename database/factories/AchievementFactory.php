<?php

use App\Achievement;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Achievement::class, function (Faker $faker) {
    return [
        'name' => $faker->title(),
        'description' => $faker->text(),
        'icon' => $faker->imageUrl(),
    ];
});
