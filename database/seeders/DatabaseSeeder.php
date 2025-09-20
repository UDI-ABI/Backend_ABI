<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'state' => '1',
            'email' => 'test2@example.com',
        ]);

        User::factory()->create([
            'state' => '1',
            'email' => 'staff@example.com',
            'role' => 'research_staff',
        ]);
    }
}
