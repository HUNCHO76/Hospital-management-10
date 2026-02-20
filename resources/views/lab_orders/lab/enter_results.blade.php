<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Enter Lab Results - Order #{{ $order->id }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded-md">
                    <ul class="list-disc ml-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg text-sm">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><span class="text-gray-500">Patient:</span> <span class="font-semibold">{{ $order->patient->full_name ?? 'N/A' }}</span></div>
                    <div><span class="text-gray-500">Doctor:</span> <span class="font-semibold">{{ $order->doctor?->user?->FirstName }} {{ $order->doctor?->user?->LastName }}</span></div>
                    <div><span class="text-gray-500">Order Date:</span> <span class="font-semibold">{{ $order->order_date?->format('M d, Y H:i') }}</span></div>
                </div>
            </div>

            <form method="POST" action="{{ route('labtech.update-results', $order->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                @foreach($order->items as $item)
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $item->labTest->test_name }}</h3>
                                <p class="text-xs text-gray-500">Reference: {{ $item->labTest->reference_range ?: 'N/A' }} {{ $item->labTest->unit }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full {{ $item->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($item->status) }}</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Result Value</label>
                                <input type="text" name="results[{{ $item->id }}]" value="{{ old('results.' . $item->id, $item->result_value) }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3" placeholder="e.g. 120">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Upload Report (Optional)</label>
                                <input type="file" name="files[{{ $item->id }}]" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3" accept=".jpg,.jpeg,.png,.pdf">
                                @if($item->file_path)
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-900">Current file</a>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Result Description</label>
                            <textarea name="texts[{{ $item->id }}]" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3" placeholder="Descriptive findings...">{{ old('texts.' . $item->id, $item->result_text) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes[{{ $item->id }}]" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3" placeholder="Technician notes...">{{ old('notes.' . $item->id, $item->notes) }}</textarea>
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-end gap-3">
                    <button type="submit" name="action" value="draft" class="px-4 py-2 bg-gray-700 text-white rounded-md text-xs font-semibold uppercase">Save as Draft</button>
                    <button type="submit" name="action" value="completed" class="px-4 py-2 bg-green-600 text-white rounded-md text-xs font-semibold uppercase">Mark Completed</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
