<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Qualification;
use Faker\Generator as Faker;

$factory->define(Qualification::class, function (Faker $faker) {
    return [
        'title' => $faker->words(2, true),
        'level_id' => array_rand(Qualification::LEVELS),
        'category_id' => array_rand(Qualification::CATEGORIES)
    ];
});
