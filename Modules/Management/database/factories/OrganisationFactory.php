<?php

namespace Modules\Management\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Management\Models\Organisation;

class OrganisationFactory extends Factory
{
    protected $model = Organisation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'description' => fake()->sentence(20),
        ];
    }
}
