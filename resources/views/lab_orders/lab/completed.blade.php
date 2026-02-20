<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Completed Lab Orders</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="GET" class="flex gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by order ID or patient" class="w-full border border-gray-300 rounded-md py-2 px-3">
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm font-semibold uppercase">Search</button>
                    <a href="{{ route('labtech.pending') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold uppercase">Pending</a>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tests</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Completed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-sm">{{ $order->patient->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $order->doctor?->user?->FirstName }} {{ $order->doctor?->user?->LastName }}</td>
                                <td class="px-6 py-4 text-sm">{{ $order->items->count() }}</td>
                                <td class="px-6 py-4 text-sm">{{ $order->updated_at?->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm"><a href="{{ route('labtech.enter-results', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">View / Edit</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-6 text-center text-gray-500 text-sm">No completed orders.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
