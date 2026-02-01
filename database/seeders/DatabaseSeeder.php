<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
            'age' => 30,
            'civil_status' => 'Single',
            'purok' => 'Purok 1',
            'is_indigent' => 'No',
            'purpose' => 'System Administrator',
            'date_issued' => now()->format('Y-m-d'),
        ]);
    }
}
