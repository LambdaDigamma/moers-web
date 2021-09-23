<?php

namespace Database\Factories;

use App\Models\RadioBroadcast;
use Illuminate\Database\Eloquent\Factories\Factory;

class RadioBroadcastFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RadioBroadcast::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4, true),
            'description' => $this->faker->text(200),
            'uid' => $this->faker->uuid(),
        ];
    }
}
