<?php

/** @var Factory $factory */

use App\RubbishStreet;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(RubbishStreet::class, function (Faker $faker) {
    return [
        'name' => $faker->streetName,
        'street_addition' => null,
        'residual_tour' => $faker->numberBetween(1, 10),
        'organic_tour' => $faker->numberBetween(1, 10),
        'paper_tour' => $faker->numberBetween(1, 10),
        'yellow_bag_tour' => $faker->numberBetween(1, 10),
        'green_cut_tour' => $faker->numberBetween(1, 10),
        'year' => Carbon::now()->year
    ];
});
