<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Billing Reports</h2></x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-5 rounded-lg shadow-sm">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                    <div>
                        <label class="block text-sm mb-1">From</label>
                        <input type="date" name="from" value="{{ $from }}" class="w-full border rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm mb-1">To</label>
                        <input type="date" name="to" value="{{ $to }}" class="w-full border rounded-md px-3 py-2">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md">Apply</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Total Invoiced</p>
                    <p class="text-2xl font-bold text-indigo-700">{{ number_format($summary['total_invoiced'], 2) }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Total Collected</p>
                    <p class="text-2xl font-bold text-green-700">{{ number_format($summary['total_collected'], 2) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b"><h3 class="font-semibold">Invoices</h3></div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Invoice</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Patient</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Cashier</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Date</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $invoice->invoice_number }}</td>
                                <td class="px-4 py-3 text-sm">{{ $invoice->patient->full_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $invoice->cashier->FirstName ?? '' }} {{ $invoice->cashier->LastName ?? '' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $invoice->invoice_date?->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($invoice->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">No invoices in selected range.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $invoices->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
