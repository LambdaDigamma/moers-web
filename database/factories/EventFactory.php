<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'date' => $faker->date('d.m.Y'),
        'time_start' => $faker->time('H:i'),
        'time_end' => $faker->time('H:i'),
        'description' => $faker->text(100),
        'url' => $faker->url,
    ];
});
