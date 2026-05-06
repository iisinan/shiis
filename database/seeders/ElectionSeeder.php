<?php

namespace Database\Seeders;

use App\Models\Election;
use App\Models\User;
use App\Models\Candidate;
use Illuminate\Database\Seeder;

class ElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $election = Election::create([
            'title' => '2026 Executive Council Election',
            'start_date' => now()->subDay(),
            'end_date' => now()->addDays(30),
            'is_active' => true,
        ]);

        $positions = [
            'Chairman', 'Vice Chairman', 'Secretary', 'Treasurer', 'PRO'
        ];

        // Create some test members and make them candidates
        $members = User::factory(10)->create([
            'is_paid' => true,
            'is_active' => true,
        ]);

        foreach ($positions as $index => $pos) {
            // Assign 2 candidates per position
            Candidate::create([
                'election_id' => $election->id,
                'user_id' => $members[$index]->id,
                'position' => $pos,
                'manifesto' => 'I promise to serve the Class of 2005 with integrity and dedication.',
                'status' => 'approved',
            ]);

            Candidate::create([
                'election_id' => $election->id,
                'user_id' => $members[$index + 5]->id,
                'position' => $pos,
                'manifesto' => 'Together we can build a stronger future for our school community.',
                'status' => 'approved',
            ]);
        }
    }
}
