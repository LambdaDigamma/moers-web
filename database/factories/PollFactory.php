<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Poll::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +4 days');

        return [
            'question' => $this->faker->sentence(6),
            'description' => $this->faker->realText(200),
            'max_check' => 1,
            'group_id' => Group::factory(),
            'can_visitors_vote' => false,
            'can_voter_see_result' => true,
            'starts_at' => $start,
            'ends_at' => $end
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($poll) {
            return $poll
                ->options()
                ->saveMany(PollOption::factory($this->faker->numberBetween(2, 4))->make());
        });
    }
}
