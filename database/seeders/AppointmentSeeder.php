<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        $reasons = [
            'Regular checkup',
            'Follow-up visit',
            'Lab test results review',
            'Blood pressure check',
            'Prescription refill',
            'Consultation on new symptoms',
        ];

        $statuses = ['scheduled', 'completed', 'cancelled'];

        foreach ($patients->take(15) as $patient) {
            // Create 2-3 appointments per patient
            for ($i = 0; $i < fake()->numberBetween(2, 3); $i++) {
                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctors->random()->id,
                    'appointment_date' => fake()->dateTimeBetween('-30 days', '+60 days'),
                    'end_time' => fake()->time(),
                    'status' => fake()->randomElement($statuses),
                    'reason' => fake()->randomElement($reasons),
                    'notes' => fake()->optional()->sentence(),
                    'reminder_sent' => fake()->boolean(70),
                ]);
            }
        }
    }
}
