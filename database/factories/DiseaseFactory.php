<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disease>
 */
class DiseaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Diabetes',
                'Hypertension',
                'Asthma',
                'Cancer',
                'Arthritis',
                'Migraine',
                'Tuberculosis',
                'Malaria',
                'Hepatitis',
                'Influenza',
            ]),
        ];
    }
}
