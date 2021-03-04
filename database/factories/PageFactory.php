<?php

/** @var Factory $factory */

use App\Models\Page;
use App\PageBlock;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Page::class, function (Faker $faker) {
    $title = $faker->sentence($faker->numberBetween(1, 3));
    $slug = Str::of($title)
        ->slug('-')
        ->append('-')
        ->append(Carbon::now()->format('mdyHis'))->__toString();
    return [
        'title' => $title,
        'slug' => $slug
    ];
});

$factory->afterCreating(Page::class, function (Page $page, Faker $faker) {
    \factory(PageBlock::class, 1)->create(['page_id' => $page->id]);
});
