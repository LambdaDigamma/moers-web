<?php

/** @var Factory $factory */

use App\Models\RubbishStreet;
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
        'plastic_tour' => $faker->numberBetween(1, 10),
        'cuttings_tour' => $faker->numberBetween(1, 10),
        'year' => Carbon::now()->year
    ];
});

$factory->state(RubbishStreet::class, 'old', function (Faker $faker) {
    return [
        'year' => Carbon::now()->subYears($faker->numberBetween(1, 10))->year
    ];
});
