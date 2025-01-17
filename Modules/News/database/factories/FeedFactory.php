<?php

namespace Modules\News\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\News\Models\Feed;

class FeedFactory extends Factory
{
    protected $model = Feed::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
        ];
    }
}

