<?php

namespace Modules\Locations\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Locations\Models\Location;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'country_code' => 'DE',
            'validated_at' => now(),
        ];
    }
}
