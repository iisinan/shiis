<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AccountantUserSeeder extends Seeder
{
    /**
     * Ensure the specified user exists and has the Accountant role.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'Yusufumar3924@gmail.com'],
            [
                'name'         => 'Yusuf Umar',
                'password'     => bcrypt('password'),
                'is_paid'      => true,
                'is_active'    => true,
                'phone_number' => '08000000002',
            ]
        );

        // Sync the Accountant role (removes any old roles, sets only Accountant)
        $user->syncRoles(['Accountant']);
    }
}
