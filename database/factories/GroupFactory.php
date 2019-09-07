<?php

/** @var Factory $factory */

use App\Group;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->text(100),
        'organisation_id' => function () {
            return factory(App\Organisation::class)->create()->id;
        },
    ];
});

$factory->afterCreating(Group::class, function ($group, $faker) {
    $users = factory(App\User::class, 6)->make();
    $group->users()->saveMany($users);
});