<?php

namespace Database\Factories;

use App\Models\PageBlock;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageBlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PageBlock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => 'markdown',
            'data' => [
                'de' => [
                    'text' => $this->faker->paragraph(8)
                ]
            ]
        ];
    }
}
