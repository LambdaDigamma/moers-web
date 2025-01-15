<?php

namespace Modules\Events\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Events\Models\TicketOption;

class TicketOptionFactory extends Factory
{
    protected $model = TicketOption::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'price' => fake()->numberBetween(10, 40),
        ];
    }
}
