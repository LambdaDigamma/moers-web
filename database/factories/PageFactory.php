<?php

namespace Database\Factories;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence($this->faker->numberBetween(1, 3));
        $slug = Str::of($title)
            ->slug('-')
            ->append('-')
            ->append(Carbon::now()->format('mdyHis'))->__toString();
        return [
            'title' => $title,
            'slug' => $slug
        ];
    }

}
