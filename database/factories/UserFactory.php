<?php

use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'login' => \Illuminate\Support\Str::random(6),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => \Illuminate\Support\Str::random(10),
    ];
});

$factory->state(User::class, 'admin', function () {
    return [
        'is_admin' => true,
    ];
});
