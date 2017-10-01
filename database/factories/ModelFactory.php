<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\App\Model\User::class, function (Faker\Generator $faker) {
    static $password;

    $name = $faker->name;

    return [
        'name' => $name,
        'username' => str_replace(" ",".",strtolower($name)),
        'slug' => str_slug($name),
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'active' => 1,
    ];
});
