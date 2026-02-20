<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\MedicineInventory;
use App\Models\MedicineManufacturer;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create manufacturers first
        $manufacturers = MedicineManufacturer::factory(5)->create();

        // Create 50 medicines
        Medicine::factory(50)
            ->recycle($manufacturers)
            ->create()
            ->each(function ($medicine) {
                // Create inventory for each medicine
                MedicineInventory::create([
                    'medicine_id' => $medicine->id,
                    'available_quantity' => fake()->numberBetween(10, 500),
                    'reserved_quantity' => fake()->numberBetween(0, 50),
                    'minimum_stock_level' => 20,
                    'maximum_stock_level' => 1000,
                    'reorder_quantity' => 200,
                    'storage_location' => 'Shelf-' . fake()->numerify('##'),
                    'last_restocked_at' => fake()->dateTimeBetween('-30 days', 'now'),
                ]);
            });
    }
}
