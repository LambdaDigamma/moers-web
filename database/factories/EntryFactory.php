<?php

/* @var $factory Factory */

use App\Entry as Entry;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Entry::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'lat' => $faker->latitude(51.4514, 51.4916),
        'lng' => $faker->longitude(6.5851, 6.6255),
        'tags' => "Backery, Bread", //implode(", ", $faker->words(3)),
        'street' => $faker->streetName,
        'house_number' => $faker->buildingNumber,
        'postcode' => $faker->postcode,
        'place' => $faker->city,
        'url' => $faker->url,
        'phone' => $faker->phoneNumber,
        'is_validated' => $faker->boolean(75),
        'monday' => "09:00 - 17:00",
        'tuesday' => "09:00 - 17:00",
        'wednesday' => "09:00 - 17:00",
        'thursday' => "09:00 - 17:00",
        'friday' => "09:00 - 17:00",
        'saturday' => "09:00 - 17:00",
        'sunday' => "09:00 - 17:00",
        'other' => "09:00 - 17:00",
    ];
});

// ----- Header ------

$factory->state(Entry::class, 'has_header', function (Faker $faker) {
    return [];
});

$factory->afterMakingState(Entry::class, 'has_header', function (Entry $event, Faker $faker) {
    $event
        ->addMediaFromUrl($faker->imageUrl(640, 200))
        ->toMediaCollection('header');
});