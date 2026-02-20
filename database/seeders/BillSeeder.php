<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = Appointment::where('status', 'completed')->limit(20)->get();

        foreach ($appointments as $appointment) {
            Bill::create([
                'patient_id' => $appointment->patient_id,
                'appointment_id' => $appointment->id,
                'amount' => fake()->randomFloat(2, 50, 500),
                'status' => fake()->randomElement(['paid', 'unpaid']),
                'payment_date' => fake()->optional(70)->dateTimeBetween('-30 days', 'now'),
            ]);
        }
    }
}
