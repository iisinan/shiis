<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing agenda to avoid duplicates
        Agenda::truncate();

        $items = [
            [
                'time' => '09:00 AM',
                'title' => 'Opening Prayer',
                'description' => 'Commencing the reunion with spiritual guidance.',
                'order' => 1,
            ],
            [
                'time' => '09:15 AM',
                'title' => 'Recitation of Holy Qur\'àn',
                'description' => 'A serene start with the word of Allah.',
                'order' => 2,
            ],
            [
                'time' => '09:30 AM',
                'title' => 'Group Photograph',
                'description' => 'Capturing the first moments of our 21-year anniversary.',
                'order' => 3,
            ],
            [
                'time' => '10:00 AM',
                'title' => 'Welcome Address by the Chairman',
                'description' => 'Opening remarks and vision for the reunion.',
                'order' => 4,
            ],
            [
                'time' => '10:30 AM',
                'title' => 'Self Introduction by Members',
                'description' => 'Getting to know where everyone is 21 years later.',
                'order' => 5,
            ],
            [
                'time' => '11:30 AM',
                'title' => 'Class Updates and Reflections',
                'description' => 'Sharing major milestones and journey since 2005.',
                'order' => 6,
            ],
            [
                'time' => '12:30 PM',
                'title' => 'Deliberations on Class Affairs',
                'description' => 'Formation of Leadership Structure including: Confirmation of Nomination, Activation of Election, Voting process and Results announcement.',
                'order' => 7,
            ],
            [
                'time' => '02:00 PM',
                'title' => 'General Discussions & Contributions',
                'description' => 'Open floor for suggestions and future planning.',
                'order' => 8,
            ],
            [
                'time' => '03:00 PM',
                'title' => 'Social Interaction & Networking',
                'description' => 'Informal session for brotherhood and networking.',
                'order' => 9,
            ],
            [
                'time' => '04:30 PM',
                'title' => 'Closing Prayer',
                'description' => 'Concluding the official ceremony with gratitude.',
                'order' => 10,
            ],
        ];

        foreach ($items as $item) {
            Agenda::create($item);
        }
    }
}
