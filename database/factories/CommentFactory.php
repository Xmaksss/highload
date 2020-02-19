<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Comment::class, function (Faker $faker) {
    $date = $faker->dateTime;

    return [
        'body' => $faker->text,
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
