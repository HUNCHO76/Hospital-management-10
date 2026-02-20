<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing Settings</h2></x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">{{ session('success') }}</div>@endif

            <form method="POST" action="{{ route('admin.billing.settings.update') }}" class="bg-white p-6 rounded-lg shadow-sm grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm mb-1">Tax Rate (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="tax_rate" value="{{ old('tax_rate', $settings->tax_rate) }}" class="w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Invoice Prefix</label>
                    <input type="text" name="invoice_prefix" value="{{ old('invoice_prefix', $settings->invoice_prefix) }}" class="w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Next Invoice Number</label>
                    <input type="number" min="1" name="next_invoice_number" value="{{ old('next_invoice_number', $settings->next_invoice_number) }}" class="w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Default Consultation Fee</label>
                    <input type="number" step="0.01" min="0" name="default_consultation_fee" value="{{ old('default_consultation_fee', $settings->default_consultation_fee) }}" class="w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Default Lab Test Fee</label>
                    <input type="number" step="0.01" min="0" name="default_lab_test_fee" value="{{ old('default_lab_test_fee', $settings->default_lab_test_fee) }}" class="w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Default Room Daily Fee</label>
                    <input type="number" step="0.01" min="0" name="default_room_daily_fee" value="{{ old('default_room_daily_fee', $settings->default_room_daily_fee) }}" class="w-full border rounded-md px-3 py-2" required>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-md">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
