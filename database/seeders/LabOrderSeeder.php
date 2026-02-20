<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\LabOrder;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class LabOrderSeeder extends Seeder
{
    public function run(): void
    {
        if (LabOrder::count() > 0) {
            return;
        }

        $patients = Patient::pluck('id');
        $doctors = Doctor::pluck('id');
        $checkupIds = \App\Models\checkup::pluck('id');

        if ($patients->isEmpty() || $doctors->isEmpty()) {
            return;
        }

        $ordersToCreate = min(40, max(10, $patients->count() * 2));

        for ($i = 0; $i < $ordersToCreate; $i++) {
            $status = fake()->randomElement(['pending', 'pending', 'completed', 'cancelled']);
            $orderDate = fake()->dateTimeBetween('-45 days', 'now');

            LabOrder::create([
                'patient_id' => $patients->random(),
                'doctor_id' => $doctors->random(),
                'checkup_id' => $checkupIds->isNotEmpty() && fake()->boolean(45) ? $checkupIds->random() : null,
                'order_date' => $orderDate,
                'status' => $status,
                'notes' => fake()->boolean(40) ? fake()->sentence() : null,
                'viewed_at' => $status === 'completed' && fake()->boolean(65)
                    ? fake()->dateTimeBetween($orderDate, 'now')
                    : null,
            ]);
        }
    }
}
