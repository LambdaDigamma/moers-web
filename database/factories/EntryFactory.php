<?php

namespace Database\Factories;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'lat' => $this->faker->latitude(51.4514, 51.4916), // TODO: ???
            'lng' => $this->faker->longitude(6.5851, 6.6255),
            'tags' => "Backery, Bread", //implode(", ", $faker->words(3)),
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'postcode' => $this->faker->postcode,
            'place' => $this->faker->city,
            'url' => $this->faker->url,
            'phone' => $this->faker->phoneNumber,
            'is_validated' => $this->faker->boolean(75),
            'monday' => "09:00 - 17:00",
            'tuesday' => "09:00 - 17:00",
            'wednesday' => "09:00 - 17:00",
            'thursday' => "09:00 - 17:00",
            'friday' => "09:00 - 17:00",
            'saturday' => "09:00 - 17:00",
            'sunday' => "09:00 - 17:00",
            'other' => "09:00 - 17:00",
        ];
    }

    public function hasHeader()
    {
        return $this->state([

        ])->afterMaking(function (Entry $entry) {
            $entry
                ->addMediaFromUrl($this->faker->imageUrl(640, 200))
                ->toMediaCollection('header');
        });
    }
}
