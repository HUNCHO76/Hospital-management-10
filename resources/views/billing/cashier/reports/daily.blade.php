<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Daily Collections Report</h2></x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-5 rounded-lg shadow-sm">
                <form method="GET" class="flex gap-3 items-end">
                    <div>
                        <label class="block text-sm mb-1">Date</label>
                        <input type="date" name="date" value="{{ $date }}" class="border rounded-md px-3 py-2">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md">Filter</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Total Collections</p>
                    <p class="text-2xl font-bold text-green-700">{{ number_format($totalCollections, 2) }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500 mb-2">Collections by Method</p>
                    @forelse($collectionsByMethod as $method => $amount)
                        <div class="flex justify-between text-sm"><span>{{ ucfirst(str_replace('_', ' ', $method)) }}</span><span>{{ number_format($amount, 2) }}</span></div>
                    @empty
                        <p class="text-sm text-gray-500">No payments found.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b"><h3 class="font-semibold">Payments</h3></div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Time</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Invoice</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Patient</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Method</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($payments as $payment)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $payment->payment_date?->format('H:i') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $payment->invoice->invoice_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $payment->invoice->patient->full_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">No payments for this date.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
