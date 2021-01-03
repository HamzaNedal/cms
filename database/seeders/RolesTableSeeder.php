<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'System Administrator', 'allowed_route' => 'admin']);
        $editorRole = Role::create(['name' => 'editor', 'display_name' => 'Supervisor', 'description' => 'System Supervisor', 'allowed_route' => 'admin']);
        $userRole = Role::create(['name' => 'user', 'display_name' => 'User', 'description' => 'Normal User', 'allowed_route' => null]);

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456789'),
            'mobile' => '123457855',
            'status' => '1',
        ]);

        $admin->attachRole($editorRole);

        $editor = User::create([
            'name' => 'Editor',
            'username' => 'editor',
            'email' => 'editor@editor.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456789'),
            'mobile' => '123457875',
            'status' => '1',
        ]);

        $editor->attachRole($adminRole);

        $user1 = User::create([
            'name' => 'user1',
            'username' => 'user1',
            'email' => 'user1@user.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456789'),
            'mobile' => '123457878',
            'status' => '1',
        ]);

        $user1->attachRole($userRole);

        $users = User::factory()
            ->count(10)
            ->hasAttached($userRole)
            ->create();

    }
}
