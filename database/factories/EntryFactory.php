<?php

use Faker\Generator as Faker;

$factory->define(App\Entry::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'tags' => implode(", ", $faker->words(3)),
        'street' => $faker->streetName,
        'house_number' => $faker->buildingNumber,
        'postcode' => $faker->postcode,
        'place' => $faker->city,
        'url' => $faker->url,
        'phone' => $faker->phoneNumber,
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
