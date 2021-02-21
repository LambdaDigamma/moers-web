<?php

namespace Database\Seeders;

use App\Entry;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Entry::class, 50)->create();

    }
}
