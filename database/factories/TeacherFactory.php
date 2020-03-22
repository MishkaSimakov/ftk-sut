<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Teacher::class, function (Faker $faker) {
    return [
        'user_id' =>  factory(\App\User::class, 1)->create()->first()->id,
    ];
});
