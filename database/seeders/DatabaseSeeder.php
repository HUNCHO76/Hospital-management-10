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
            'FirstName' => 'Admin',
            'MiddleName' => 'Super',
            'LastName' => 'User',
            'status' => 1, // Active status
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Ensure password is hashed
            'Role' => 'admin', // Assigning the 'admin' role
        ]);
    }
}
