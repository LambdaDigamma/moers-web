<?php

use Faker\Generator as Faker;

$factory->define(App\Entry::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'lat' => $faker->latitude(6.5851, 6.5851),
        'lng' => $faker->longitude(51.4283, 51.4916),
        'tags' => implode(", ", $faker->words(3)),
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
