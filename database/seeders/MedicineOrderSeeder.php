<?php

namespace Database\Seeders;

use App\Models\MedicineOrder;
use App\Models\MedicineOrderItem;
use App\Models\MedicineSupplier;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Database\Seeder;

class MedicineOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = MedicineSupplier::factory(5)->create();
        $medicines = Medicine::all();
        $pharmacist = User::where('Role', 'pharmacist')->first() ?? User::where('Role', 'admin')->first();

        $statuses = ['pending', 'processing', 'delivered', 'cancelled'];

        for ($i = 0; $i < 20; $i++) {
            $totalAmount = 0;

            $order = MedicineOrder::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'supplier_id' => $suppliers->random()->id,
                'order_date' => fake()->dateTimeBetween('-60 days', 'now'),
                'expected_delivery_date' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
                'actual_delivery_date' => fake()->optional(70)->dateTimeBetween('-30 days', 'now'),
                'status' => fake()->randomElement($statuses),
                'ordered_by' => $pharmacist->id,
                'notes' => fake()->optional(40)->sentence(),
            ]);

            // Add random medicines to order (3-8 items)
            $selectedMedicines = $medicines->random(fake()->numberBetween(3, 8));

            foreach ($selectedMedicines as $medicine) {
                $quantity = fake()->numberBetween(50, 500);
                $unitPrice = $medicine->unit_price * fake()->randomFloat(1, 0.7, 0.95);
                $amount = $quantity * $unitPrice;

                MedicineOrderItem::create([
                    'medicine_order_id' => $order->id,
                    'medicine_id' => $medicine->id,
                    'quantity' => $quantity,
                    'received_quantity' => $order->status === 'delivered' ? $quantity : fake()->numberBetween(0, $quantity),
                    'unit_price' => $unitPrice,
                    'total_amount' => $amount,
                ]);

                $totalAmount += $amount;
            }

            $order->update(['total_amount' => $totalAmount]);
        }
    }
}
