<?php

namespace Database\Factories;

use App\Models\MedicineManufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    public function definition(): array
    {
        $medicineName = [
            'Amoxicillin', 'Ibuprofen', 'Paracetamol', 'Aspirin', 'Metformin',
            'Lisinopril', 'Losartan', 'Omeprazole', 'Cetirizine', 'Atorvastatin',
            'Simvastatin', 'Amlodipine', 'Metoprolol', 'Enalapril', 'Fluoxetine'
        ];

        $categories = ['Antibiotic', 'Pain Relief', 'Fever', 'Cardiac', 'Diabetes', 'Hypertension', 'Allergy', 'GI', 'Cholesterol'];

        return [
            'name' => fake()->randomElement($medicineName),
            'generic_name' => fake()->word(),
            'description' => fake()->sentence(),
            'category' => fake()->randomElement($categories),
            'manufacturer_id' => MedicineManufacturer::factory(),
            'unit_price' => fake()->randomFloat(2, 0.50, 50),
            'strength' => fake()->randomElement(['250mg', '500mg', '1000mg', '5ml', '10ml']),
            'route' => fake()->randomElement(['oral', 'injection', 'topical', 'inhalation']),
            'is_controlled' => fake()->boolean(20),
            'requires_prescription' => fake()->boolean(60),
        ];
    }
}
