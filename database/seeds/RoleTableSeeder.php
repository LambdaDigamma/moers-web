<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $owner = new Role();
        $owner->name         = 'owner';
        $owner->display_name = 'Project Owner';
        $owner->description  = 'User is the owner of a given project';
        $owner->save();

        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'User Administrator';
        $admin->description = 'User is allowed to manage and edit other users';
        $admin->save();

        $user = User::where('id', '=', '1')->first();

        $user->attachRole($admin);

    }

}
