<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the admin role if it doesn't exist
        $adminRole = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        // Create the 'access:admin' ability if it doesn't exist
        $adminAbility = Bouncer::ability()->firstOrCreate([
            'name' => 'access-admin',
            'title' => 'Can access admin area',
        ]);

        // Assign the ability to the role
        Bouncer::allow($adminRole)->to($adminAbility);

        // Create or update the administrator user
        $email = config('app.admin_email');
        $password = config('app.admin_password'); // In production, this should be changed immediately

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrator',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        // Assign the role to the user
        Bouncer::assign($adminRole)->to($admin);

        $this->command->info("Admin user created/updated with email: {$email}");
    }
}
