<?php

namespace Database\Seeders;

use App\Models\Prescription;
use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicalRecords = MedicalRecord::all();

        foreach ($medicalRecords as $medicalRecord) {
            // Create 1-2 prescriptions per medical record
            for ($i = 0; $i < fake()->numberBetween(1, 2); $i++) {
                Prescription::create([
                    'medical_record_id' => $medicalRecord->id,
                    'medication' => fake()->randomElement([
                        'Aspirin', 'Ibuprofen', 'Paracetamol', 'Amoxicillin', 'Metformin',
                        'Lisinopril', 'Omeprazole', 'Atorvastatin', 'Sertraline', 'Loratadine'
                    ]),
                    'dosage' => fake()->randomElement(['5mg', '10mg', '500mg', '1000mg', '250mg']),
                    'instructions' => fake()->optional(70)->sentence(),
                    'created_at' => fake()->dateTimeBetween('-90 days', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

