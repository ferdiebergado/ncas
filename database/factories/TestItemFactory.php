<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TestItem;
use App\Competency;
use Faker\Generator as Faker;

$factory->define(TestItem::class, function (Faker $faker) {
    $type = $faker->randomElement(array_keys(TestItem::TYPES));
    $options = [];
    $numOptions = 4;

    if ($type === 'M') {
        for ($i = 0; $i < $numOptions; $i++) {
            $options = array_merge($options, [$this->faker->word]);
        }
        $answer = $options[$this->faker->numberBetween(0, $numOptions - 1)];
    }

    if ($type === 'T') {
        $answer = $faker->randomElement(['T', 'F']);
    }

    if ($type === 'I') {
        $answer = $faker->word;
    }

    return [
        'competency_uuid' => Competency::inRandomOrder()->first()->uuid,
        'type' => $type,
        'options' => $options,
        'answer' => $answer,
        'question' => $this->faker->sentence,
        'timeout' => $this->faker->numberBetween(10, 60)
    ];
});
