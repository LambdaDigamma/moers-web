<?php

use Illuminate\Database\Seeder;
use App\User;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Bouncer::allow('superadmin')->everything();
        Bouncer::allow('superadmin')->toManage(User::class);
        Bouncer::allow('superadmin')->to('access-admin');
        Bouncer::allow('superadmin')->to('create-user', User::class);
        Bouncer::allow('superadmin')->to('read-user', User::class);
        Bouncer::allow('superadmin')->to('update-user', User::class);
        Bouncer::allow('superadmin')->to('delete-user', User::class);

        Bouncer::allow('admin')->everything();
        Bouncer::forbid('admin')->toManage(User::class);

    }
}
