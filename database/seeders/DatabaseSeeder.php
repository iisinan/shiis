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
            ['email' => 'finance@shiis05.com'],
            [
                'name' => 'Reunion Finance Team',
                'password' => bcrypt('password'),
                'is_paid' => true,
                'is_active' => true,
                'phone_number' => '08000000001',
            ]
        );
        $accountant->assignRole('Accountant');

        // Default Agenda
        $agendaItems = [
            [
                'time' => '09:00 AM',
                'title' => 'Arrival & Registration',
                'description' => 'Welcome home! Collect your reunion kit, name tag, and commemorative souvenir at the entrance.',
                'location' => 'Main Reception Hall',
                'order' => 1
            ],
            [
                'time' => '10:00 AM',
                'title' => 'Opening Ceremony',
                'description' => 'Official kick-off of the SHIIS 05 Reunion. Welcome address by the organizing committee and special guest speakers.',
                'location' => 'Grand Ballroom',
                'order' => 2
            ],
            [
                'time' => '11:30 AM',
                'title' => 'Networking & Refreshments',
                'description' => 'Connect with old friends over light snacks and drinks. A great time to catch up on the last two decades.',
                'location' => 'Garden Terrace',
                'order' => 3
            ],
            [
                'time' => '01:00 PM',
                'title' => 'The Journey So Far (Panel)',
                'description' => 'An inspiring session featuring alumni sharing their career paths, life lessons, and success stories.',
                'location' => 'Auditorium',
                'order' => 4
            ],
            [
                'time' => '03:00 PM',
                'title' => 'Gala Dinner & Awards',
                'description' => 'A premium 3-course dinner followed by special recognition awards for outstanding alumni.',
                'location' => 'Main Banquet Hall',
                'order' => 5
            ],
            [
                'time' => '06:00 PM',
                'title' => 'Closing Remarks & Photos',
                'description' => 'Final group photography and official closing of the reunion festivities.',
                'location' => 'Front Courtyard',
                'order' => 6
            ]
        ];

        foreach ($agendaItems as $item) {
            \App\Models\Agenda::firstOrCreate(['title' => $item['title']], $item);
        }
    }
}
