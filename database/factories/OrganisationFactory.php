<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Organisation::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->sentence(20)
    ];
});
