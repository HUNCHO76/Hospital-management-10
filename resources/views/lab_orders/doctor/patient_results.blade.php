<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lab Results Timeline - {{ $patient->full_name }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse($orders as $order)
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                        <div class="flex justify-between mb-4">
                            <h3 class="font-semibold">Order #{{ $order->id }}</h3>
                            <span class="text-sm text-gray-500">{{ $order->order_date?->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="border rounded p-3 {{ $item->isAbnormal() ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    <p class="font-semibold text-sm">{{ $item->labTest->test_name }}</p>
                                    <p class="text-sm">{{ $item->result_value ?: 'Pending' }} {{ $item->labTest->unit }}</p>
                                    <p class="text-xs text-gray-500">Ref: {{ $item->labTest->reference_range ?: 'N/A' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg text-gray-500 text-center">No lab orders found for this patient.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
