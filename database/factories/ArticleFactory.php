<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraphs(100, true),
        'user_id' => factory(\App\User::class, 1)->create()->first()->id,
        'points' => $faker->numberBetween(0, 10000),
        'is_blank' => false,
    ];
});
