<?php

/** @var Factory $factory */

use App\Model;
use App\PageBlock;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(PageBlock::class, function (Faker $faker) {
    return [
        'de' => [
            'type' => 'markdown',
            'data' => [
                'text' => $faker->paragraph(8)
            ]
        ]
    ];
});
