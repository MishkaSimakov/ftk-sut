<?php

use Faker\Generator as Faker;

$factory->define(\App\Article::class, function (Faker $faker) {
    return [
        'title' => 'Test',
        'body' => 'TestTestTestTest123',
        'user_id' => 1,
        'points' => 1000,
        'isPublished' => 1
    ];
});
