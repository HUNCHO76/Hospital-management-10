<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cashier Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">Today's Collections</p>
                    <p class="text-2xl font-bold text-green-700">{{ number_format($todayCollections, 2) }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">Pending Invoices</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $pendingInvoicesCount }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">Patients in Queue</p>
                    <p class="text-2xl font-bold text-indigo-700">{{ $queuePatients->count() }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-5">
                <h3 class="font-semibold mb-3">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('cashier.invoices.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">New Invoice</a>
                    <a href="{{ route('cashier.billing-queue') }}" class="px-4 py-2 bg-gray-700 text-white rounded-md text-sm">View Queue</a>
                    <a href="{{ route('cashier.reports.daily') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm">Daily Report</a>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-5 border-b">
                    <h3 class="font-semibold">Pending Queue (Today)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Patient</th>
                                <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Visit Time</th>
                                <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($queuePatients as $visit)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $visit->patient->full_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $visit->appointment_date?->format('M d, Y H:i') }}</td>
                                    <td class="px-4 py-3 text-sm">{{ ucfirst($visit->status) }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('cashier.invoices.create', $visit->patient_id) }}" class="text-indigo-600 hover:text-indigo-900">Invoice</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">No patients in queue today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
