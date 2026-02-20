<?php

namespace Database\Seeders;

use App\Models\Admission;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Database\Seeder;

class AdmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $rooms = Room::all();

        foreach ($patients->take(10) as $patient) {
            $admissionDate = fake()->dateTimeBetween('-30 days', 'now');
            $dischargeDate = fake()->optional(50)->dateTimeBetween($admissionDate, '+30 days');
            
            Admission::create([
                'patient_id' => $patient->id,
                'room_id' => $rooms->isNotEmpty() ? $rooms->random()->id : 1,
                'admission_date' => $admissionDate->format('Y-m-d'),
                'discharge_date' => $dischargeDate ? $dischargeDate->format('Y-m-d') : null,
                'notes' => fake()->optional(60)->paragraph(),
                'created_at' => $admissionDate,
                'updated_at' => now(),
            ]);
        }
    }
}
