<?php

namespace Database\Seeders;

use App\Models\DoctorPatient;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class DoctorPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        // Assign each patient to 1-3 doctors
        foreach ($patients as $patient) {
            $assignedDoctors = $doctors->random(fake()->numberBetween(1, 3));

            foreach ($assignedDoctors as $doctor) {
                // Check if relationship already exists
                if (!DoctorPatient::where('doctor_id', $doctor->id)
                    ->where('patient_id', $patient->id)
                    ->exists()) {
                    DoctorPatient::create([
                        'doctor_id' => $doctor->id,
                        'patient_id' => $patient->id,
                        'assigned_at' => fake()->dateTimeBetween('-180 days', 'now'),
                    ]);
                }
            }
        }
    }
}
