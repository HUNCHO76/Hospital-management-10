<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        $diagnoses = [
            'Hypertension',
            'Type 2 Diabetes',
            'Asthma',
            'Hyperlipidemia',
            'Atrial Fibrillation',
            'Migraine',
            'Gastritis',
            'Arthritis',
            'Anxiety Disorder',
            'Depression',
        ];

        foreach ($patients->take(20) as $patient) {
            // Create 1-3 medical records per patient
            for ($i = 0; $i < fake()->numberBetween(1, 3); $i++) {
                MedicalRecord::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctors->random()->id,
                    'visit_date' => fake()->dateTimeBetween('-180 days', 'now'),
                    'diagnosis' => fake()->randomElement($diagnoses),
                    'treatment' => fake()->sentence(),
                    'notes' => fake()->paragraph(),
                    'vital_signs' => [
                        'blood_pressure' => fake()->numerify('###/##'),
                        'heart_rate' => fake()->numberBetween(60, 100),
                        'temperature' => fake()->numberBetween(36, 39),
                        'respiratory_rate' => fake()->numberBetween(12, 20),
                    ],
                    'allergies' => [fake()->word(), fake()->word()],
                    'chronic_conditions' => [fake()->word(), fake()->word()],
                ]);
            }
        }
    }
}
