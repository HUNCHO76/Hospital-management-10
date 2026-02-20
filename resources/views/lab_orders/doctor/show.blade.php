<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lab Order #{{ $order->id }}</h2>
            <a href="{{ route('doctor.lab-orders.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md text-xs font-semibold uppercase">Back</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div><span class="text-gray-500">Patient:</span> <span class="font-semibold">{{ $order->patient->full_name ?? 'N/A' }}</span></div>
                    <div><span class="text-gray-500">Doctor:</span> <span class="font-semibold">{{ $order->doctor?->user?->FirstName }} {{ $order->doctor?->user?->LastName }}</span></div>
                    <div><span class="text-gray-500">Order Date:</span> <span class="font-semibold">{{ $order->order_date?->format('M d, Y H:i') }}</span></div>
                </div>
                @if($order->notes)
                    <p class="mt-4 text-sm"><span class="text-gray-500">Notes:</span> {{ $order->notes }}</p>
                @endif
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ordered Tests & Results</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="border rounded-md p-4 {{ $item->isAbnormal() ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->labTest->test_name }}</p>
                                    <p class="text-xs text-gray-500">Ref: {{ $item->labTest->reference_range ?: 'N/A' }} {{ $item->labTest->unit }}</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full {{ $item->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($item->status) }}</span>
                            </div>

                            <div class="mt-3 text-sm">
                                @if($item->status === 'completed')
                                    <p>
                                        <span class="text-gray-500">Result:</span>
                                        <span class="font-semibold {{ $item->isAbnormal() ? 'text-red-700' : 'text-gray-900' }}">{{ $item->result_value ?: 'N/A' }} {{ $item->labTest->unit }}</span>
                                    </p>
                                    @if($item->result_text)
                                        <p class="mt-1"><span class="text-gray-500">Details:</span> {{ $item->result_text }}</p>
                                    @endif
                                    @if($item->file_path)
                                        <p class="mt-1"><a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">View Report File</a></p>
                                    @endif
                                    @if($item->enteredBy)
                                        <p class="mt-1 text-xs text-gray-500">Entered by {{ $item->enteredBy->FirstName }} {{ $item->enteredBy->LastName }} at {{ $item->entered_at?->format('M d, Y H:i') }}</p>
                                    @endif
                                @else
                                    <p class="text-yellow-700 font-medium">Pending</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
