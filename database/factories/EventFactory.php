<?php

/* @var $factory Factory */

use App\Event as Event;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'date' => $faker->date('d.m.Y'),
        'time_start' => $faker->time('H:i'),
        'time_end' => $faker->time('H:i'),
        'description' => $faker->text(100),
        'url' => $faker->url,
    ];
});
