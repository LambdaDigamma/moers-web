<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superadmin = User::factory()->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@lambdadigamma.com',
            'password' => bcrypt('secret')
        ]);

        $superadmin->assign('superadmin');

        User::factory(5)->create();

    }
}
