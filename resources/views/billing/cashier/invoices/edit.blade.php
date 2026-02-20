<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Invoice {{ $invoice->invoice_number }}</h2></x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('cashier.invoices.update', $invoice->id) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="bg-white p-6 rounded-lg shadow-sm grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="text-sm">Due Date</label>
                        <input type="date" name="due_date" value="{{ optional($invoice->due_date)->format('Y-m-d') }}" class="w-full border rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="text-sm">Discount Type</label>
                        <select name="discount_type" class="w-full border rounded-md px-3 py-2">
                            <option value="none" @selected($invoice->discount_type === 'none')>None</option>
                            <option value="percentage" @selected($invoice->discount_type === 'percentage')>Percentage</option>
                            <option value="fixed" @selected($invoice->discount_type === 'fixed')>Fixed</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm">Discount Value</label>
                        <input type="number" step="0.01" min="0" name="discount_value" value="{{ $invoice->discount_value }}" class="w-full border rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="text-sm">Tax Rate (%)</label>
                        <input type="number" step="0.01" min="0" name="tax_rate" value="{{ $invoice->tax_rate }}" class="w-full border rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="text-sm">Status</label>
                        <select name="status" class="w-full border rounded-md px-3 py-2">
                            <option value="draft" @selected($invoice->status === 'draft')>Draft</option>
                            <option value="pending" @selected($invoice->status === 'pending')>Pending</option>
                            <option value="cancelled" @selected($invoice->status === 'cancelled')>Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm space-y-3">
                    <h3 class="font-semibold">Items</h3>
                    @foreach($invoice->items as $index => $item)
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                            <input type="hidden" name="items[{{ $index }}][item_id]" value="{{ $item->item_id }}">
                            <div class="md:col-span-2"><input type="text" name="items[{{ $index }}][item_type]" value="{{ $item->item_type }}" class="w-full border rounded-md px-2 py-1"></div>
                            <div class="md:col-span-5"><input type="text" name="items[{{ $index }}][description]" value="{{ $item->description }}" class="w-full border rounded-md px-2 py-1"></div>
                            <div class="md:col-span-2"><input type="number" min="1" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" class="w-full border rounded-md px-2 py-1"></div>
                            <div class="md:col-span-3"><input type="number" step="0.01" min="0" name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}" class="w-full border rounded-md px-2 py-1"></div>
                        </div>
                    @endforeach
                    <div>
                        <label class="text-sm">Notes</label>
                        <textarea name="notes" rows="3" class="w-full border rounded-md px-3 py-2">{{ $invoice->notes }}</textarea>
                    </div>
                </div>

                <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-md">Update Invoice</button>
            </form>
        </div>
    </div>
</x-app-layout>
