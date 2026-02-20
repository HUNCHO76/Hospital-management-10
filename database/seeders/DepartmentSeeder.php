<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular diseases'],
            ['name' => 'Neurology', 'description' => 'Nervous system and brain disorders'],
            ['name' => 'Orthopedics', 'description' => 'Bone and joint disorders'],
            ['name' => 'Pediatrics', 'description' => 'Children\'s health'],
            ['name' => 'Obstetrics & Gynecology', 'description' => 'Pregnancy and women\'s health'],
            ['name' => 'General Medicine', 'description' => 'Internal medicine'],
            ['name' => 'Surgery', 'description' => 'Surgical procedures'],
            ['name' => 'Emergency', 'description' => 'Emergency and trauma care'],
            ['name' => 'Laboratory', 'description' => 'Pathology and tests'],
            ['name' => 'Radiology', 'description' => 'X-rays and imaging'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
