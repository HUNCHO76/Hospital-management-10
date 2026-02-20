<?php

namespace Database\Seeders;

use App\Models\LabTest;
use Illuminate\Database\Seeder;

class LabTestSeeder extends Seeder
{
    public function run(): void
    {
        $tests = [
            [
                'test_name' => 'Complete Blood Count',
                'short_name' => 'CBC',
                'category' => 'Hematology',
                'reference_range' => '4.0 - 10.0',
                'unit' => 'x10^9/L',
                'price' => 25.00,
            ],
            [
                'test_name' => 'Lipid Profile',
                'short_name' => 'LIPID',
                'category' => 'Biochemistry',
                'reference_range' => '< 200',
                'unit' => 'mg/dL',
                'price' => 40.00,
            ],
            [
                'test_name' => 'Fasting Blood Glucose',
                'short_name' => 'FBG',
                'category' => 'Biochemistry',
                'reference_range' => '70 - 99',
                'unit' => 'mg/dL',
                'price' => 15.00,
            ],
            [
                'test_name' => 'Liver Function Test',
                'short_name' => 'LFT',
                'category' => 'Biochemistry',
                'reference_range' => 'See panel values',
                'unit' => null,
                'price' => 55.00,
            ],
            [
                'test_name' => 'Urinalysis',
                'short_name' => 'UA',
                'category' => 'Microbiology',
                'reference_range' => 'Negative/Normal',
                'unit' => null,
                'price' => 20.00,
            ],
        ];

        foreach ($tests as $test) {
            LabTest::updateOrCreate(
                ['test_name' => $test['test_name']],
                array_merge($test, ['is_active' => true])
            );
        }
    }
}
