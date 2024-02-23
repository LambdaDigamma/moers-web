<?php

namespace Database\Factories;

use App\Models\RadioBroadcast;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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

    public function activeStartEnd()
    {
        return $this
            ->state(fn () => [
                'starts_at' => Carbon::now()->subRealMinutes($this->faker->numberBetween(1, 29))->toDateTimeString(),
                'ends_at' => Carbon::now()->addRealMinutes($this->faker->numberBetween(29, 180))->toDateTimeString(),
            ]);
    }

    public function activeStart()
    {
        return $this
            ->state(fn () => [
                'starts_at' => Carbon::now()
                    ->subRealMinutes($this->faker->numberBetween(1, 29))
                    ->toDateTimeString(),
            ]);
    }

    public function upcomingStart()
    {
        return $this
            ->state(fn () => [
                'starts_at' => Carbon::now()
                    ->addRealMinutes($this->faker->numberBetween(1, 24) * 60)
                    ->toDateTimeString(),
            ]);
    }

    public function upcomingToday()
    {
        return $this
            ->state(fn () => [
                'starts_at' => $this->faker->dateTimeBetween(
                    Carbon::now()->toDateTimeString(),
                    Carbon::now()->setHours(23)->setMinutes(59)->setSeconds(0)->toDateTimeString()
                )
            ]);
    }
}
