<?php

namespace Modules\News\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\News\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'summary' => $this->faker->sentences(2, true),
        ];
    }

    public function published(): PostFactory
    {
        return $this->state(fn () => [
            'published_at' => now(),
        ]);
    }

    public function notPublished(): PostFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => null,
            ];
        });
    }

    public function archived(): PostFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'archived_at' => now(),
            ];
        });
    }

    public function notArchived(): PostFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'archived_at' => null,
            ];
        });
    }
}

