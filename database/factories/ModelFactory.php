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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->name,
        'category_id' => 10,
    ];
});

$factory->define(App\Cheap::class,function(Faker\Generator $facker){
    return[
        'name' => $facker->name,
        'desc' => $facker->name,
        'full' => 200,
        'cut' => 20,
        'amount' => 1000,
        'indate' => $facker->datetime,
    ];
});
