<?php

namespace Database\Seeders;

use App\Models\MedicineBatch;
use App\Models\Medicine;
use App\Models\MedicineSupplier;
use Illuminate\Database\Seeder;

class MedicineBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = MedicineSupplier::factory(5)->create();
        $medicines = Medicine::all();

        foreach ($medicines as $medicine) {
            // Create 2-4 batches per medicine
            for ($i = 0; $i < fake()->numberBetween(2, 4); $i++) {
                MedicineBatch::create([
                    'medicine_id' => $medicine->id,
                    'batch_number' => 'BATCH-' . strtoupper(fake()->bothify('????-####')),
                    'expiry_date' => fake()->dateTimeBetween('+1 month', '+3 years')->format('Y-m-d'),
                    'manufacture_date' => fake()->dateTimeBetween('-2 years', '-6 months')->format('Y-m-d'),
                    'quantity_received' => fake()->numberBetween(100, 1000),
                    'quantity_available' => fake()->numberBetween(50, 1000),
                    'supplier_id' => $suppliers->random()->id,
                    'cost_price' => fake()->randomFloat(2, $medicine->unit_price * 0.6, $medicine->unit_price * 0.9),
                    'received_at' => fake()->dateTimeBetween('-60 days', 'now'),
                ]);
            }
        }
    }
}
