<?php

/* @var $factory Factory */

use App\AdvEvent;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(AdvEvent::class, function (Faker $faker) {

    $start = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');
    $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +2 days');

    // TODO: Add other extra fakes

    $extras = collect([
        'locationName' => $faker->words(3)
    ]);

    return [
        'name' => $faker->sentence(3),
        'start_date' => $start->format('Y-m-d H:i:s'),
        'end_date' => $end->format('Y-m-d H:i:s'),
        'description' => $faker->realText(200),
        'url' => $faker->url,
        'image_path' => $faker->imageUrl(640, 480),
        'is_published' => $faker->boolean(85),
        'extras' => $extras,
    ];

});
