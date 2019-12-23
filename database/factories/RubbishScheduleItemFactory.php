<?php

/** @var Factory $factory */

use App\RubbishScheduleItem;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(RubbishScheduleItem::class, function (Faker $faker) {
    return [
        'date' => $faker->date(),
        'residual_tours' => $faker->numberBetween(1, 10),
        'organic_tours' => $faker->numberBetween(1, 10),
        'paper_tours' => $faker->numberBetween(1, 10),
        'plastic_tours' => $faker->numberBetween(1, 10),
        'cuttings_tours' => $faker->numberBetween(1, 10),
    ];
});
