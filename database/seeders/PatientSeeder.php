<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = User::where('Role', 'local')->get();

        foreach ($patients as $user) {
            Patient::create([
                'user_id' => $user->id,
                'registration_no' => 'PAT-' . strtoupper(uniqid()),
                'full_name' => $user->FirstName . ' ' . $user->LastName,
                'age' => fake()->numberBetween(5, 90),
                'gender' => fake()->randomElement(['M', 'F']),
                'marital_status' => fake()->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
                'phone' => fake()->phoneNumber(),
                'occupation' => fake()->jobTitle(),
                'country' => fake()->country(),
                'payment_method' => fake()->randomElement(['Cash', 'Insurance', 'Card']),
            ]);
        }
    }
}
