<?php

namespace Database\Seeders;

use App\Models\SampleTestResult;
use App\Models\Patient;
use App\Models\Checkup;
use Illuminate\Database\Seeder;

class SampleTestResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $checkups = Checkup::all();

        foreach ($patients as $patient) {
            // Create 2-4 test results per patient
            for ($i = 0; $i < fake()->numberBetween(2, 4); $i++) {
                SampleTestResult::create([
                    'patient_id' => $patient->id,
                    'checkup_id' => $checkups->isNotEmpty() ? $checkups->random()->id : null,
                    'status' => fake()->randomElement(['Normal', 'Abnormal', 'Critical', 'Pending']),
                    'percentage' => fake()->numberBetween(50, 100),
                    'remarks' => fake()->optional(60)->sentence(),
                    'created_at' => fake()->dateTimeBetween('-90 days', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

