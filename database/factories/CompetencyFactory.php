<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Competency;
use Faker\Generator as Faker;

$factory->define(Competency::class, function (Faker $faker) {
    return [
        'title' => $faker->words(2, true),
        'level_id' => array_rand(Competency::LEVELS),
        'category_id' => array_rand(Competency::CATEGORIES),
        'coc_number' => $faker->numberBetween(1, 3),
        'coc_title' => $faker->words(2, true),
        'units_covered' => [
            $faker->sentence,
            $faker->sentence,
            $faker->sentence
        ]
    ];
});
