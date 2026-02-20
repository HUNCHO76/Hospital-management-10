<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice {{ $invoice->invoice_number }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('cashier.invoices.payment', $invoice->id) }}" class="px-3 py-2 bg-green-600 text-white rounded-md text-sm">Record Payment</a>
                <a href="{{ route('cashier.invoices.print', $invoice->id) }}" target="_blank" class="px-3 py-2 bg-gray-700 text-white rounded-md text-sm">Print</a>
                @if(in_array($invoice->status, ['draft', 'pending']))
                    <a href="{{ route('cashier.invoices.edit', $invoice->id) }}" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">Edit</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))<div class="bg-green-100 text-green-800 p-4 rounded-md">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="bg-red-100 text-red-800 p-4 rounded-md">{{ session('error') }}</div>@endif

            <div class="bg-white p-6 rounded-lg shadow-sm grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div><span class="text-gray-500">Patient:</span> <span class="font-semibold">{{ $invoice->patient->full_name ?? 'N/A' }}</span></div>
                <div><span class="text-gray-500">Invoice Date:</span> <span class="font-semibold">{{ $invoice->invoice_date?->format('M d, Y H:i') }}</span></div>
                <div><span class="text-gray-500">Status:</span> <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</span></div>
                <div><span class="text-gray-500">Subtotal:</span> {{ number_format($invoice->subtotal, 2) }}</div>
                <div><span class="text-gray-500">Discount:</span> {{ number_format($invoice->discount_amount, 2) }}</div>
                <div><span class="text-gray-500">Tax:</span> {{ number_format($invoice->tax_amount, 2) }}</div>
                <div><span class="text-gray-500">Total:</span> <span class="font-semibold">{{ number_format($invoice->total_amount, 2) }}</span></div>
                <div><span class="text-gray-500">Paid:</span> <span class="font-semibold text-green-700">{{ number_format($invoice->paid_amount, 2) }}</span></div>
                <div><span class="text-gray-500">Balance:</span> <span class="font-semibold text-red-700">{{ number_format($invoice->balance, 2) }}</span></div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b"><h3 class="font-semibold">Invoice Items</h3></div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Type</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Description</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Qty</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Unit</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($invoice->items as $item)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $item->item_type }}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->description }}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b"><h3 class="font-semibold">Payment History</h3></div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Date</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Amount</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Method</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Reference</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Cashier</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($invoice->payments as $payment)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $payment->payment_date?->format('M d, Y H:i') }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-4 py-3 text-sm">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td class="px-4 py-3 text-sm">{{ $payment->reference_number ?: 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $payment->cashier->FirstName ?? '' }} {{ $payment->cashier->LastName ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">No payments recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
