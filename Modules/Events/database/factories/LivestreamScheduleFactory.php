<?php

namespace Modules\Events\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Events\Models\LivestreamSchedule;

class LivestreamScheduleFactory extends Factory
{
    protected $model = LivestreamSchedule::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'start_date' => Carbon::now()->addHour(),
            'end_date' => Carbon::now()->addHours(5),
        ];
    }
}
