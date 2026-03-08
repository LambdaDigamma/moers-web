<?php

namespace Modules\Management\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Management\Models\Organisation;

class OrganisationFactory extends Factory
{
    protected $model = Organisation::class;

    public function definition(): array
    {
        $name = fake()->company;

        return [
            'name' => $name,
            'slug' => fake()->unique()->slug(3),
            'description' => fake()->sentence(20),
        ];
    }
}
