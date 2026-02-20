<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Insurance Claims</h2></x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))<div class="bg-green-100 text-green-800 p-4 rounded-md">{{ session('success') }}</div>@endif

            <div class="bg-white p-5 rounded-lg shadow-sm">
                <form method="GET" class="flex gap-3 items-end">
                    <div>
                        <label class="block text-sm mb-1">Status</label>
                        <select name="status" class="border rounded-md px-3 py-2">
                            <option value="">All</option>
                            @foreach(['pending','approved','rejected','paid'] as $s)
                                <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md">Filter</button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Claim #</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Invoice</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Patient</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Provider</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Claimed</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Approved</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($claims as $claim)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $claim->claim_number }}</td>
                                <td class="px-4 py-3 text-sm">{{ $claim->invoice->invoice_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $claim->invoice->patient->full_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $claim->insurance_provider }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($claim->total_claimed, 2) }}</td>
                                <td class="px-4 py-3 text-sm">{{ number_format($claim->approved_amount ?? 0, 2) }}</td>
                                <td class="px-4 py-3 text-sm">{{ ucfirst($claim->status) }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <form method="POST" action="{{ route('admin.billing.insurance-claims.update', $claim->id) }}" class="flex gap-2 items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="border rounded px-2 py-1 text-xs">
                                            @foreach(['pending','approved','rejected','paid'] as $s)
                                                <option value="{{ $s }}" @selected($claim->status === $s)>{{ ucfirst($s) }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" step="0.01" min="0" name="approved_amount" value="{{ $claim->approved_amount }}" class="border rounded px-2 py-1 w-24 text-xs" placeholder="Approved">
                                        <button type="submit" class="text-xs px-2 py-1 bg-indigo-600 text-white rounded">Save</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-4 py-6 text-center text-sm text-gray-500">No insurance claims available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $claims->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
