<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing History - {{ $patient->full_name }}</h2></x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Invoice</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Date</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Total</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Paid</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $invoice->invoice_number }}</td>
                                <td class="px-4 py-3 text-sm">{{ $invoice->invoice_date?->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($invoice->total_amount, 2) }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($invoice->paid_amount, 2) }}</td>
                                <td class="px-4 py-3 text-sm"><a class="text-indigo-600" href="{{ route('cashier.invoices.show', $invoice->id) }}">View</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">No billing records for this patient.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $invoices->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
