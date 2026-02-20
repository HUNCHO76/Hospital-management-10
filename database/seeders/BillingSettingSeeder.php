<?php

namespace Database\Seeders;

use App\Models\BillingSetting;
use Illuminate\Database\Seeder;

class BillingSettingSeeder extends Seeder
{
    public function run(): void
    {
        BillingSetting::updateOrCreate(
            ['id' => 1],
            [
                'tax_rate' => 18,
                'invoice_prefix' => 'INV',
                'next_invoice_number' => 1,
                'default_consultation_fee' => 10000,
                'default_lab_test_fee' => 15000,
                'default_room_daily_fee' => 25000,
            ]
        );
    }
}
