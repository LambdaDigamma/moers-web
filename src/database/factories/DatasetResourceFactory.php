<?php

namespace Database\Factories;

use App\Models\DatasetResource;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatasetResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatasetResource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $auto_updating_interval = null;
        $error = null;

        if ($this->faker->boolean(75)) {
            $auto_updating_interval = $this->faker->numberBetween(1, 50) * 15;
        }

        if ($this->faker->boolean(75)) {
            $error = $this->faker->sentence(10);
        }

        return [
            'name' => $this->faker->sentence(3),
            'source_url' => $this->faker->url,
            'format' => collect(['csv', 'json', 'geojson', 'xml', 'text'])->random(),
            'error' => $error,
            'auto_updating_interval' => $auto_updating_interval,
        ];
    }
}
