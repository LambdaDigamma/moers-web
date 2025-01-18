<?php

namespace Modules\Multimedia\Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Multimedia\Models\RadioBroadcast;

class RadioBroadcastFactory extends Factory
{
    protected $model = RadioBroadcast::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4, true),
            'description' => fake()->text(200),
            'uid' => fake()->uuid(),
        ];
    }

    public function activeStartEnd(): RadioBroadcastFactory
    {
        return $this
            ->state(fn () => [
                'starts_at' => Carbon::now()->subRealMinutes(fake()->numberBetween(1, 29))->toDateTimeString(),
                'ends_at' => Carbon::now()->addRealMinutes(fake()->numberBetween(29, 180))->toDateTimeString(),
            ]);
    }

    public function activeStart(): RadioBroadcastFactory
    {
        return $this
            ->state(fn () => [
                'starts_at' => Carbon::now()
                    ->subRealMinutes(fake()->numberBetween(1, 29))
                    ->toDateTimeString(),
            ]);
    }

    public function upcomingStart(): RadioBroadcastFactory
    {
        return $this
            ->state(fn () => [
                'starts_at' => Carbon::now()
                    ->addRealMinutes(fake()->numberBetween(1, 24) * 60)
                    ->toDateTimeString(),
            ]);
    }

    public function upcomingToday(): RadioBroadcastFactory
    {
        return $this
            ->state(fn () => [
                'starts_at' => fake()->dateTimeBetween(
                    Carbon::now()->toDateTimeString(),
                    Carbon::now()->setHours(23)->setMinutes(59)->setSeconds(0)->toDateTimeString()
                ),
            ]);
    }
}
