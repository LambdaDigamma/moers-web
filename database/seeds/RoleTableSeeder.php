<?php

use App\Permission;
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
        $owner->name            = 'owner';
        $owner->display_name    = 'Project Owner';
        $owner->description     = 'User is the owner of a given project';
        $owner->save();

        $admin = new Role();
        $admin->name            = 'admin';
        $admin->display_name    = 'User Administrator';
        $admin->description     = 'User is allowed to manage and edit other users';
        $admin->save();

        $editor = new Role();
        $editor->name           = 'editor';
        $editor->display_name   = 'Editor';
        $editor->description    = 'User is allowed to create, edit and delete';
        $editor->save();

        $reader = new Role();
        $reader->name           = 'reader';
        $reader->display_name   = 'Reader';
        $reader->description    = 'User not allowed to change anything';
        $reader->save();

        // Role

        $readRole = new Permission();
        $readRole->name             = 'read-role';
        $readRole->display_name     = 'Read Roles';
        $readRole->description      = 'Read Roles';
        $readRole->save();

        $createRole = new Permission();
        $createRole->name           = 'create-role';
        $createRole->display_name   = 'Create Role';
        $createRole->description    = 'Create New Role';

        $editRole = new Permission();
        $editRole->name             = 'edit-role';
        $editRole->display_name     = 'Edit Role';
        $editRole->description      = 'Edit Role';

        $deleteRole = new Permission();
        $deleteRole->name           = 'delete-role';
        $deleteRole->display_name   = 'Delete Role';
        $deleteRole->description    = 'Delete Role';

        // User

        $readUser = new Permission();
        $readUser->name             = 'read-user';
        $readUser->display_name     = 'Read User';
        $readUser->description      = 'Read User';
        $readUser->save();

        $createUser = new Permission();
        $createUser->name           = 'create-user';
        $createUser->display_name   = 'Create User';
        $createUser->description    = 'Create New User';

        $editUser = new Permission();
        $editUser->name             = 'edit-user';
        $editUser->display_name     = 'Edit User';
        $editUser->description      = 'Edit User';

        $deleteUser = new Permission();
        $deleteUser->name           = 'delete-user';
        $deleteUser->display_name   = 'Delete User';
        $deleteUser->description    = 'Delete User';

        // Admin

        $readAdmin = new Permission();
        $readAdmin->name             = 'read-admin';
        $readAdmin->display_name     = 'Read Admin';
        $readAdmin->description      = 'Read Admin Properties';
        $readAdmin->save();

        $createAdmin = new Permission();
        $createAdmin->name           = 'create-admin';
        $createAdmin->display_name   = 'Create Admin';
        $createAdmin->description    = 'Create Admin Properties';

        $editAdmin = new Permission();
        $editAdmin->name             = 'edit-admin';
        $editAdmin->display_name     = 'Edit Admin';
        $editAdmin->description      = 'Edit Admin Properties';

        $deleteAdmin = new Permission();
        $deleteAdmin->name           = 'delete-admin';
        $deleteAdmin->display_name   = 'Delete Admin';
        $deleteAdmin->description    = 'Delete Admin Properties';

        // Organisation

        $createOrganisation = new Permission();
        $createOrganisation->name         = 'create-organisation';
        $createOrganisation->display_name = 'Create Organisation';
        $createOrganisation->description  = 'Create New Organisation';
        $createOrganisation->save();

        $editOrganisation = new Permission();
        $editOrganisation->name         = 'edit-organisation';
        $editOrganisation->display_name = 'Edit Organisation';
        $editOrganisation->description  = 'Edit Organisation';
        $editOrganisation->save();

        $deleteOrganisation = new Permission();
        $deleteOrganisation->name         = 'delete-organisation';
        $deleteOrganisation->display_name = 'Delete Organisation';
        $deleteOrganisation->description  = 'Delete Organisation';
        $deleteOrganisation->save();

        // Entry

        $createEntry = new Permission();
        $createEntry->name         = 'create-entry';
        $createEntry->display_name = 'Create Entry';
        $createEntry->description  = 'Create New Entry';
        $createEntry->save();

        $editEntry = new Permission();
        $editEntry->name         = 'edit-entry';
        $editEntry->display_name = 'Edit Entry';
        $editEntry->description  = 'Edit Entry';
        $editEntry->save();

        $deleteEntry = new Permission();
        $deleteEntry->name         = 'delete-entry';
        $deleteEntry->display_name = 'Delete Entry';
        $deleteEntry->description  = 'Delete Entry';
        $deleteEntry->save();

        // Events

        $createEvent = new Permission();
        $createEvent->name         = 'create-event';
        $createEvent->display_name = 'Create Event';
        $createEvent->description  = 'Create New Event';
        $createEvent->save();

        $editEvent = new Permission();
        $editEvent->name         = 'edit-event';
        $editEvent->display_name = 'Edit Event';
        $editEvent->description  = 'Edit Event';
        $editEvent->save();

        $deleteEvent = new Permission();
        $deleteEvent->name         = 'delete-event';
        $deleteEvent->display_name = 'Delete Event';
        $deleteEvent->description  = 'Delete Event';
        $deleteEvent->save();


        $owner->attachPermissions([$createAdmin, $readAdmin, $editAdmin, $deleteAdmin,
                                   $createUser, $readUser, $editUser, $deleteUser,
                                   $createRole, $readRole, $editRole, $deleteRole,
                                   $createOrganisation, $editOrganisation, $deleteOrganisation,
                                   $createEntry, $editEntry, $deleteEntry,
                                   $createEvent, $editEvent, $deleteEvent]);

        $admin->attachPermissions([$createUser, $readUser, $editUser, $deleteUser,
                                   $createOrganisation, $editOrganisation, $deleteOrganisation,
                                   $createEntry, $editEntry, $deleteEntry,
                                   $createEvent, $editEvent, $deleteEvent]);

        $editor->attachPermissions([$createOrganisation, $editOrganisation, $deleteOrganisation,
                                    $createEntry, $editEntry, $deleteEntry,
                                    $createEvent, $editEvent, $deleteEvent]);


        $user = User::where('id', '=', '1')->first();

        $user->attachRole($owner);

    }

}
