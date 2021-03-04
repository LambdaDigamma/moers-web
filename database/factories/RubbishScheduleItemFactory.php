<?php

/** @var Factory $factory */

use App\Models\RubbishScheduleItem;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(RubbishScheduleItem::class, function (Faker $faker) {
    return [
        'date' => Carbon::now()->addDays($faker->numberBetween(0, 20))->toDateString(),
        'residual_tours' => $faker->numberBetween(1, 10),
        'organic_tours' => $faker->numberBetween(1, 10),
        'paper_tours' => $faker->numberBetween(1, 10),
        'plastic_tours' => $faker->numberBetween(1, 10),
        'cuttings_tours' => $faker->numberBetween(1, 10),
    ];
});
