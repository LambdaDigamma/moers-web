<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Poll;
use App\Models\User;
use Bouncer;
use Illuminate\Database\Seeder;

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
        Bouncer::allow('superadmin')->to('create-poll', Poll::class);
        Bouncer::allow('superadmin')->to('read-poll', Poll::class);
        Bouncer::allow('superadmin')->to('create-group', Group::class);
        Bouncer::allow('superadmin')->to('read-group', Group::class);

        Bouncer::allow('admin')->everything();
        Bouncer::forbid('admin')->toManage(User::class);

        Bouncer::allow('student')->to('read-poll', Poll::class);

    }
}
