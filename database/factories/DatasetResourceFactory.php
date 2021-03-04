<?php

/** @var Factory $factory */

use App\Models\DatasetResource;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(DatasetResource::class, function (Faker $faker) {

    $auto_updating_interval = null;
    $error = null;

    if ($faker->boolean(75)) {
        $auto_updating_interval = $faker->numberBetween(1, 50) * 15;
    }

    if ($faker->boolean(75)) {
        $error = $faker->sentence(10);
    }

    return [
        'name' => $faker->sentence(3),
        'source_url' => $faker->url,
        'format' => collect(['csv', 'json', 'geojson', 'xml', 'text'])->random(),
        'error' => $error,
        'auto_updating_interval' => $auto_updating_interval,
    ];
});
