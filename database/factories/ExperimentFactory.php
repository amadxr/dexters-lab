<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Experiment::class, function (Faker $faker) {
    return [
        'title' => $faker->colorName,
        'background' => $faker->realText,
        'falsifiable_hypothesis' => $faker->sentence,
        'details' => $faker->realText,
        'results' => $faker->realText,
        'validated_learning' => $faker->realText,
        'next_action' => $faker->realText
    ];
});
