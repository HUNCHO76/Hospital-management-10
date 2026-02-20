<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingSetting;
use Illuminate\Http\Request;

class BillingSettingController extends Controller
{
    public function edit()
    {
        $settings = BillingSetting::current();

        return view('billing.admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tax_rate' => 'required|numeric|min:0|max:100',
            'invoice_prefix' => 'required|string|max:10',
            'next_invoice_number' => 'required|integer|min:1',
            'default_consultation_fee' => 'required|numeric|min:0',
            'default_lab_test_fee' => 'required|numeric|min:0',
            'default_room_daily_fee' => 'required|numeric|min:0',
        ]);

        $settings = BillingSetting::current();
        $settings->update($validated);

        return back()->with('success', 'Billing settings updated successfully.');
    }
}
