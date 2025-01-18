<?php

namespace Modules\Management\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Management\Models\Group;
use Modules\Management\Models\Organisation;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'description' => fake()->text(100),
            'organisation_id' => Organisation::factory(),
        ];
    }
}
