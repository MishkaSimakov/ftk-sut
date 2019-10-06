<?php

use Faker\Generator as Faker;
use \App\Rating;


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Rating::class, function (Faker $faker) {
    return [
        'date' => now(),
        'type' => 'monthly',
    ];
});
