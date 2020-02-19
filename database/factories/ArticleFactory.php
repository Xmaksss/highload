<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'preview' => $faker->text(500),
        'body' => $faker->text(2000),
        'published_at' => $faker->dateTime
    ];
});
