<?php

namespace Database\Seeders;

use App\Models\Checkup;
use App\Models\Pretest;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class CheckupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pretests = Pretest::all();
        $doctors = Doctor::all();

        foreach ($pretests as $pretest) {
            // Create 1-2 checkups per pretest
            for ($i = 0; $i < fake()->numberBetween(1, 2); $i++) {
                Checkup::create([
                    'pretest_id' => $pretest->id,
                    'doctor_id' => $doctors->isNotEmpty() ? $doctors->random()->id : 1,
                    'disease' => fake()->randomElement([
                        'Hypertension', 'Diabetes', 'Asthma', 'CAD', 'GERD',
                        'Arthritis', 'Anemia', 'Thyroid', 'Migraine', 'Anxiety'
                    ]),
                    'status' => fake()->randomElement(['completed', 'inprogress', 'pending']),
                    'created_at' => fake()->dateTimeBetween('-90 days', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

