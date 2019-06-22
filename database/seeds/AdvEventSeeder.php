<?php

use App\AdvEvent;
use Illuminate\Database\Seeder;

class AdvEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AdvEvent::class, 50)->create();
    }
}
