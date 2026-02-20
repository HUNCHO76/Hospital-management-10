<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [
            ['name' => 'Hypertension', 'description' => 'High blood pressure'],
            ['name' => 'Type 2 Diabetes', 'description' => 'Blood sugar disorder'],
            ['name' => 'Asthma', 'description' => 'Chronic respiratory disease'],
            ['name' => 'CAD', 'description' => 'Coronary Artery Disease'],
            ['name' => 'Atrial Fibrillation', 'description' => 'Irregular heartbeat'],
            ['name' => 'Hyperlipidemia', 'description' => 'High cholesterol'],
            ['name' => 'Arthritis', 'description' => 'Joint inflammation'],
            ['name' => 'GERD', 'description' => 'Acid reflux disease'],
            ['name' => 'Thyroid Disorder', 'description' => 'Thyroid dysfunction'],
            ['name' => 'Anxiety Disorder', 'description' => 'Mental health condition'],
            ['name' => 'Depression', 'description' => 'Mood disorder'],
            ['name' => 'Chronic Kidney Disease', 'description' => 'Kidney dysfunction'],
            ['name' => 'COPD', 'description' => 'Chronic Obstructive Pulmonary Disease'],
            ['name' => 'Migraine', 'description' => 'Severe headache'],
            ['name' => 'Anemia', 'description' => 'Low blood cells'],
        ];

        foreach ($diseases as $disease) {
            Disease::create($disease);
        }
    }
}
