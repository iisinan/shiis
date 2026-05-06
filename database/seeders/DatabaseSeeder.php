<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Election Admin',
            'Finance Admin',
            'Accountant',
            'Moderator',
            'Member'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@shiis2005.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'is_paid' => true,
                'is_active' => true,
                'phone_number' => '08000000000',
            ]
        );

        $admin->assignRole('Super Admin');

        $accountant = User::firstOrCreate(
            ['email' => 'accountant@shiis2005.com'],
            [
                'name' => 'Main Accountant',
                'password' => bcrypt('password'),
                'is_paid' => true,
                'is_active' => true,
                'phone_number' => '08000000001',
            ]
        );
        $accountant->assignRole('Accountant');
    }
}
