<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superadmin = factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@lambdadigamma.com',
            'password' => bcrypt('secret')
        ]);

        $superadmin->assign('superadmin');

        factory(User::class, 50)->create();

    }
}
