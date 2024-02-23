<?php

namespace Database\Factories;

use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PollOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'votes' => 0,
        ];
    }
}
