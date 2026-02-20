<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'FirstName' => 'Admin',
            'MiddleName' => 'System',
            'LastName' => 'User',
            'email' => 'admin@hospital.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'Role' => 'admin',
            'status' => 1,
        ]);

        // Create sample doctors
        User::factory(5)
            ->doctor()
            ->create();

        // Create sample nurses
        User::factory(8)
            ->nurse()
            ->create();

        // Create sample pharmacist
        User::factory(2)
            ->pharmacist()
            ->create();

        // Create sample receptionist
        User::factory(3)->create([
            'Role' => 'receptionist',
            'status' => 1,
        ]);

        // Create sample cashier
        User::factory(2)->create([
            'Role' => 'cashier',
            'status' => 1,
        ]);

        // Create sample lab technicians
        User::factory(2)->create([
            'Role' => 'Lab Technician',
            'status' => 1,
        ]);

        // Create sample patients
        User::factory(20)->create([
            'Role' => 'local',
            'status' => 1,
        ]);
    }
}
