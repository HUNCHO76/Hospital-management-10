<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing Queue</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-5 rounded-lg shadow-sm">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search patient name..." class="border border-gray-300 rounded-md px-3 py-2">
                    <input type="date" name="date" value="{{ $date }}" class="border border-gray-300 rounded-md px-3 py-2">
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">Filter</button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b"><h3 class="font-semibold">Recent Visits Without Invoice Shortcut</h3></div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Patient</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Visit Type</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Date</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($appointmentQueue as $row)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $row->patient->full_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">OPD Consultation</td>
                                <td class="px-4 py-3 text-sm">{{ $row->appointment_date?->format('M d, Y H:i') }}</td>
                                <td class="px-4 py-3 text-sm"><a href="{{ route('cashier.invoices.create', $row->patient_id) }}" class="text-indigo-600">Create Invoice</a></td>
                            </tr>
                        @endforeach
                        @foreach($admissionQueue as $row)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $row->patient->full_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">IPD Admission</td>
                                <td class="px-4 py-3 text-sm">{{ $row->admission_date?->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm"><a href="{{ route('cashier.invoices.create', $row->patient_id) }}" class="text-indigo-600">Create Invoice</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b"><h3 class="font-semibold">Pending Invoices</h3></div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Invoice</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Patient</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Total</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Paid</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($pendingInvoices as $invoice)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $invoice->invoice_number }}</td>
                                <td class="px-4 py-3 text-sm">{{ $invoice->patient->full_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($invoice->total_amount, 2) }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($invoice->paid_amount, 2) }}</td>
                                <td class="px-4 py-3 text-sm">{{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{ route('cashier.invoices.show', $invoice->id) }}" class="text-indigo-600">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">No pending invoices.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $pendingInvoices->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
