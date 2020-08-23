<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Application;
use App\Qualification;
use Faker\Generator as Faker;

$factory->define(Application::class, function (Faker $faker) {
    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'sex' => $faker->randomElement(['M', 'F']),
        'mobile' => $faker->regexify('/^(9){1}[0-9]{9}$/'),
        'email' => $faker->email,
        'qualification_id' => (factory(Qualification::class)->create())->qualification_id
    ];
});
