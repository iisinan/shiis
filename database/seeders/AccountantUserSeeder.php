<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountantUserSeeder extends Seeder
{
    /**
     * Ensure the specified user has the Accountant role and the correct password.
     */
    public function run(): void
    {
        // Case-insensitive email lookup to handle any capitalisation the user registered with
        $user = User::whereRaw('LOWER(email) = ?', ['yusufumar3924@gmail.com'])->first();

        if ($user) {
            // User exists — force-reset their password and ensure they are active
            $user->update([
                'password'  => bcrypt('password'),
                'is_paid'   => true,
                'is_active' => true,
            ]);
        } else {
            // User does not exist — create them fresh
            $user = User::create([
                'name'         => 'Yusuf Umar',
                'email'        => 'yusufumar3924@gmail.com',
                'password'     => bcrypt('password'),
                'is_paid'      => true,
                'is_active'    => true,
                'phone_number' => '08000000002',
            ]);
        }

        // Assign Accountant role (removes all other roles)
        $user->syncRoles(['Accountant']);
    }
}
