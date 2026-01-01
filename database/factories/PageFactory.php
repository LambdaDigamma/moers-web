<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title' => ['en' => $this->faker->sentence(3)],
            'summary' => ['en' => $this->faker->sentence(10, true)],
        ];
    }

    public function published(): PageFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => now(),
            ];
        });
    }

    public function notPublished(): PageFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => null,
            ];
        });
    }

    public function archived(): PageFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'archived_at' => now(),
            ];
        });
    }

    public function notArchived(): PageFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'archived_at' => null,
            ];
        });
    }
}
