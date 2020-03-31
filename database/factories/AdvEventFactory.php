<?php

/* @var $factory Factory */

use App\AdvEvent;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(AdvEvent::class, function (Faker $faker) {

    $start = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');
    $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +2 days');

    // TODO: Add other extra fakes

    $extras = collect([
        'locationName' => $faker->word()
    ]);

    return [
        'name' => $faker->sentence(3),
//        'start_date' => $start->format('Y-m-d H:i:s'),
//        'end_date' => $end->format('Y-m-d H:i:s'),
        'description' => $faker->realText(200),
        'url' => $faker->url,
        'image_path' => $faker->imageUrl(640, 480),
        'is_published' => $faker->boolean(85),
        'extras' => $extras,
    ];

});

$factory->state(AdvEvent::class, 'active_start_end', function (Faker $faker) {
    return [
        'start_date' => Carbon::now()->subRealMinutes($faker->numberBetween(1, 29))->toDateTimeString(),
        'end_date' => Carbon::now()->addRealMinutes($faker->numberBetween(29, 180))->toDateTimeString(),
    ];
});

$factory->state(AdvEvent::class, 'active_start', function (Faker $faker) {
    return [
        'start_date' => Carbon::now()->subRealMinutes($faker->numberBetween(1, 29))->toDateTimeString(),
    ];
});

$factory->state(AdvEvent::class, 'upcoming_start', function (Faker $faker) {
    return [
        'start_date' => Carbon::now()->addRealMinutes($faker->numberBetween(1, 24) * 60)->toDateTimeString(),
    ];
});

$factory->state(AdvEvent::class, 'upcoming_today', function (Faker $faker) {
    return [
        'start_date' => $faker
            ->dateTimeBetween(
                Carbon::now()->toDateTimeString(),
                Carbon::now()
                    ->setHours(23)
                    ->setMinutes(59)
                    ->setSeconds(0)
                    ->toDateTimeString()
            )
    ];
});

$factory->state(AdvEvent::class, 'has_header', function (Faker $faker) {
    return [];
});

$factory->afterMakingState(AdvEvent::class, 'has_header', function (AdvEvent $event, Faker $faker) {
    $event
        ->addMediaFromUrl($faker->imageUrl(640, 480))
        ->toMediaCollection('header');
});