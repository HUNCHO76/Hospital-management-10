<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineManufacturerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'country' => fake()->country(),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'license_number' => 'LIC-' . fake()->numerify('####-####'),
        ];
    }
}
