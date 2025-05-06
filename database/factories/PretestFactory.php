<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pretest>
 */
class PretestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::factory(),
            'nurse_id' => \App\Models\User::factory(),
            'height' => $this->faker->randomFloat(2, 100, 200), // e.g., 170.50 cm
            'weight' => $this->faker->randomFloat(2, 40, 150),  // e.g., 65.25 kg
            'blood_pressure' => $this->faker->regexify('\d{2,3}/\d{2,3}'), // e.g., "120/80"
            'temperature' => $this->faker->randomFloat(1, 35, 40), // e.g., 36.6
            'pulse_rate' => $this->faker->numberBetween(50, 120), // e.g., 72
            'respiration_rate' => $this->faker->numberBetween(12, 25), // e.g., 16
            'notes' => $this->faker->sentence(),
        ];
    }
}
