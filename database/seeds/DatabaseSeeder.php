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

        // Create Abilities and Roles
        $this->call(BouncerSeeder::class);

        // Create Admin User
        $this->call(UserTableSeeder::class);

        Model::reguard();

    }
}
