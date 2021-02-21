<?php

namespace Database\Seeders;

use App\Poll;
use App\PollOption;
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

        factory(Poll::class, 50)->create()->each(function ($poll) {

            $option = factory(PollOption::class)->make();

            $poll->options()->save($option);

        });
    }
}
