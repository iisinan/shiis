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
                'title' => 'Opening Prayer',
                'description' => 'Commencing the reunion with a moment of spiritual reflection and prayer.',
                'location' => 'Main Hall',
                'order' => 1
            ],
            [
                'time' => '09:15 AM',
                'title' => 'Recitation of Holy Quràn',
                'description' => 'Soulful recitation of the Holy Quràn to bless the gathering.',
                'location' => 'Main Hall',
                'order' => 2
            ],
            [
                'time' => '09:45 AM',
                'title' => 'Group Photograph',
                'description' => 'Capturing the historic reunion of the Class of 2005.',
                'location' => 'Front Courtyard',
                'order' => 3
            ],
            [
                'time' => '10:30 AM',
                'title' => 'Welcome Address',
                'description' => 'Official welcome speech by the Chairman of the organizing committee.',
                'location' => 'Main Hall',
                'order' => 4
            ],
            [
                'time' => '11:00 AM',
                'title' => 'Self Introduction by Members',
                'description' => 'Opportunity for all attendees to re-introduce themselves and share their journey.',
                'location' => 'Main Hall',
                'order' => 5
            ],
            [
                'time' => '12:30 PM',
                'title' => 'Class Updates & Reflections',
                'description' => 'Updates on class members and reflections on our shared history.',
                'location' => 'Main Hall',
                'order' => 6
            ],
            [
                'time' => '02:00 PM',
                'title' => 'Leadership & Elections',
                'description' => 'Deliberations on class affairs, confirmation of nominations, and live digital election on the website.',
                'location' => 'Main Hall',
                'order' => 7
            ],
            [
                'time' => '03:30 PM',
                'title' => 'General Discussions',
                'description' => 'Open floor for contributions and discussions on future class projects.',
                'location' => 'Main Hall',
                'order' => 8
            ],
            [
                'time' => '04:30 PM',
                'title' => 'Social Interaction',
                'description' => 'Networking session and informal social interaction among colleagues.',
                'location' => 'Garden Area',
                'order' => 9
            ],
            [
                'time' => '05:30 PM',
                'title' => 'Closing Prayer',
                'description' => 'Closing the event with prayers and final remarks.',
                'location' => 'Main Hall',
                'order' => 10
            ]
        ];

        foreach ($agendaItems as $item) {
            \App\Models\Agenda::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
