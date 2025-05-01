<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_no' => $this->faker->unique()->numberBetween(1000, 9999),
            'full_name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(1, 100),
            'marital_status' => $this->faker->randomElement(['single', 'married', 'divorced']),
            'phone' => $this->faker->phoneNumber(),
            'occupation' => $this->faker->word(),
            'country' => $this->faker->country(),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card', 'insurance']),
        ];
    }
}
