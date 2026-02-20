<?php

namespace Database\Seeders;

use App\Models\Pretest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class PretestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $nurses = User::where('Role', 'nurse')->get();

        foreach ($patients as $patient) {
            // Create 2-4 pretests per patient
            for ($i = 0; $i < fake()->numberBetween(2, 4); $i++) {
                Pretest::create([
                    'patient_id' => $patient->id,
                    'nurse_id' => $nurses->isNotEmpty() ? $nurses->random()->id : User::first()->id,
                    'height' => fake()->numberBetween(150, 200),
                    'weight' => fake()->numberBetween(45, 120),
                    'blood_pressure' => fake()->randomElement([
                        '120/80', '130/85', '140/90', '110/70', '125/75', '118/76'
                    ]),
                    'temperature' => fake()->numberBetween(360, 380) / 10,
                    'pulse_rate' => fake()->numberBetween(60, 100),
                    'respiration_rate' => fake()->numberBetween(12, 20),
                    'notes' => fake()->optional(50)->sentence(),
                    'created_at' => fake()->dateTimeBetween('-90 days', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

