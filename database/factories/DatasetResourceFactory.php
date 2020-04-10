<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DatasetResource;
use Faker\Generator as Faker;

$factory->define(DatasetResource::class, function (Faker $faker) {

    $auto_updating_interval = null;

    if ($faker->boolean(75)) {
        $auto_updating_interval = $faker->numberBetween(1, 50) * 15;
    }

    return [
        'name' => $faker->sentence(3),
        'source_url' => $faker->url,
        'format' => collect(['csv', 'json', 'geojson', 'xml', 'text'])->random(),
        'is_valid' => $faker->boolean(75),
        'auto_updating_interval' => $auto_updating_interval,
    ];
});
