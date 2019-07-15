<?php

/* @var $factory Factory */

use App\Model;
use App\Poll;
use App\PollOption;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Poll::class, function (Faker $faker) {

    $start = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');
    $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +4 days');

    return [
        'question' => $faker->sentence(6),
        'description' => $faker->realText(200),
        'max_check' => 1,
        'can_visitors_vote' => false,
        'can_voter_see_result' => true,
        'starts_at' => $start,
        'ends_at' => $end
    ];
});

$factory->define(PollOption::class, function (Faker $faker) {

    return [
        'name' => $faker->sentence(3),
        'votes' => 0,
    ];
});
