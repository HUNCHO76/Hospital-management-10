<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            'Cardiologist', 'Neurologist', 'Orthopedist', 'Pediatrician',
            'Obstetrician', 'Surgeon', 'Internist', 'Emergency Medicine'
        ];

        $doctors = User::where('Role', 'doctor')->get();

        foreach ($doctors as $doctor) {
            Doctor::create([
                'user_id' => $doctor->id,
                'specialization' => fake()->randomElement($specializations),
                'qualification' => fake()->randomElement(['MBBS', 'MD', 'MRCP', 'FRCS']),
                'department_id' => Department::inRandomOrder()->first()->id,
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
            ]);
        }
    }
}
