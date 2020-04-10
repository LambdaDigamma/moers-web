<?php

/** @var Factory $factory */

use App\Dataset;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Dataset::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'licence' => 'Datenlizenz Deutschland – Zero – Version 2.0',
        'source_url' => $faker->url,
        'categories' => implode(", ", ['Bevölkerung', 'Statistiken', 'Sozial'])
    ];
});

$factory->afterCreating(App\Dataset::class, function ($dataset, $faker) {
    $dataset->resources()->save(factory(App\DatasetResource::class)->make());
});