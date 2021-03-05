<?php

namespace Database\Factories;

use App\Models\Dataset;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatasetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dataset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'licence' => 'Datenlizenz Deutschland – Zero – Version 2.0',
            'source_url' => $this->faker->url,
            'categories' => implode(", ", ['Bevölkerung', 'Statistiken', 'Sozial'])
        ];
    }
}
