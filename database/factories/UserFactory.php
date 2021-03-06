<?php

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

/** @noinspection PhpUndefinedVariableInspection */
/** @noinspection PhpUndefinedMethodInspection */
$factory->define(App\User::class, function (Faker $faker) {
    $updatet_at = $faker->dateTime();

    $data = [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => $faker->randomElement([null, $updatet_at]),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'role' => $faker->randomElement(config('auth.roles')),
        'api_token' => str_unique_random(60),
        'rate_limit' => random_int(30, 180),
        'remember_token' => str_random(100),
        'created_at' => $faker->dateTime($updatet_at),
        'updated_at' => $updatet_at,
    ];

    return $data;
});
