<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineSupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'contact_person' => fake()->name(),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'payment_terms' => fake()->randomElement(['Net 30', 'Net 60', 'COD', 'Prepaid']),
            'delivery_days' => fake()->numberBetween(1, 14),
            'is_active' => true,
        ];
    }
}
