<?php

namespace Modules\Events\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Events\Models\Event;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->realText(),
            'url' => fake()->url,
            // 'published_at' => fake()->boolean(85) ? fake()->dateTimeBetween('-60 days', '-1 days') : null,
            'extras' => collect(['locationName' => fake()->word()]),
        ];
    }

    public function activeStartEnd(): EventFactory
    {
        return $this
            ->state(fn () => [
                'start_date' => Carbon::now()->subRealMinutes($this->faker->numberBetween(1, 29))->toDateTimeString(),
                'end_date' => Carbon::now()->addRealMinutes($this->faker->numberBetween(29, 180))->toDateTimeString(),
            ]);
    }

    public function activeStart(): EventFactory
    {
        return $this
            ->state(fn () => [
                'start_date' => Carbon::now()->subRealMinutes($this->faker->numberBetween(1, 29))->toDateTimeString(),
            ]);
    }

    public function upcomingStart(): EventFactory
    {
        return $this
            ->state(fn () => [
                'start_date' => Carbon::now()->addRealMinutes($this->faker->numberBetween(1, 24) * 60)->toDateTimeString(),
            ]);
    }

    public function upcomingToday(): EventFactory
    {
        return $this
            ->state(fn () => [
                'start_date' => $this->faker->dateTimeBetween(Carbon::now()->toDateTimeString(), Carbon::now()->setHours(23)->setMinutes(59)->setSeconds(0)->toDateTimeString()),
            ]);
    }

    public function published(): EventFactory
    {
        return $this->state(fn () => [
            'published_at' => now(),
        ]);
    }

    public function notPublished(): EventFactory
    {
        return $this->state(fn () => [
            'published_at' => null,
        ]);
    }

    public function scheduledInFuture(): EventFactory
    {
        return $this->state(fn () => [
            'scheduled_at' => $this->faker->dateTimeInInterval('tomorrow'),
        ]);
    }

    public function notScheduled(): EventFactory
    {
        return $this->state(fn () => [
            'scheduled_at' => null,
        ]);
    }

    public function archived(): EventFactory
    {
        return $this->state(fn () => [
            'archived_at' => now(),
        ]);
    }

    public function notArchived(): EventFactory
    {
        return $this->state(fn () => [
            'archived_at' => null,
        ]);
    }

    // public function withHeaderMedia()
    // {
    //     return $this->afterCreating(function (Event $event) {
    //         $event
    //             ->addMediaFromUrl($this->faker->imageUrl(640, 480))
    //             ->toMediaCollection('header');
    //     });
    // }
}
