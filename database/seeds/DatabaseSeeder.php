<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();

        $this->call(BouncerSeeder::class);

        $this->call(UserTableSeeder::class);

        $this->call(OrganisationSeeder::class);

        $this->call(EntrySeeder::class);

        Model::reguard();

    }
}
