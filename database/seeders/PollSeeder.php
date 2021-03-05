<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Poll::factory(50)->create()->each(function ($poll) {

            $option = PollOption::factory()->make();
            $poll->options()->save($option);

        });
    }
}
