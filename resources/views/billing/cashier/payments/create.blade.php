<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Record Payment - {{ $invoice->invoice_number }}</h2></x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 text-red-800 p-4 rounded-md mb-4">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p class="text-sm mb-1">Patient: <strong>{{ $invoice->patient->full_name ?? 'N/A' }}</strong></p>
                <p class="text-sm mb-1">Total: <strong>{{ number_format($invoice->total_amount, 2) }}</strong></p>
                <p class="text-sm mb-4">Outstanding Balance: <strong class="text-red-700">{{ number_format($invoice->balance, 2) }}</strong></p>

                <form method="POST" action="{{ route('cashier.invoices.payments', $invoice->id) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">Payment Date</label>
                        <input type="datetime-local" name="payment_date" value="{{ now()->format('Y-m-d\\TH:i') }}" class="w-full border rounded-md px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Amount</label>
                        <input type="number" step="0.01" min="0.01" max="{{ $invoice->balance }}" name="amount" class="w-full border rounded-md px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full border rounded-md px-3 py-2" required>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="insurance">Insurance</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Reference Number</label>
                        <input type="text" name="reference_number" class="w-full border rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Notes</label>
                        <textarea name="notes" rows="3" class="w-full border rounded-md px-3 py-2"></textarea>
                    </div>
                    <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-md">Record Payment</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
