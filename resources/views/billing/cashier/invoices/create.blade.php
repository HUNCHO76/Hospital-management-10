<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Invoice</h2>
    </x-slot>

    <div class="py-8" x-data="invoiceForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($errors->any())
                <div class="bg-red-100 text-red-800 p-4 rounded-md">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('cashier.invoices.store') }}" class="space-y-6">
                @csrf

                <div class="bg-white p-6 rounded-lg shadow-sm grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Patient</label>
                        <select name="patient_id" class="w-full border rounded-md px-3 py-2" required>
                            <option value="">Select patient</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" @selected(old('patient_id', $patient?->id) == $p->id)>{{ $p->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Due Date</label>
                        <input type="date" name="due_date" class="w-full border rounded-md px-3 py-2" value="{{ old('due_date') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Tax Rate (%)</label>
                        <input type="number" step="0.01" min="0" name="tax_rate" x-model.number="taxRate" class="w-full border rounded-md px-3 py-2" value="{{ old('tax_rate', $settings->tax_rate) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Discount Type</label>
                        <select name="discount_type" x-model="discountType" class="w-full border rounded-md px-3 py-2">
                            <option value="none">None</option>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Discount Value</label>
                        <input type="number" step="0.01" min="0" name="discount_value" x-model.number="discountValue" class="w-full border rounded-md px-3 py-2" value="{{ old('discount_value', 0) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Save As</label>
                        <select name="save_as" class="w-full border rounded-md px-3 py-2">
                            <option value="draft">Draft</option>
                            <option value="pending">Pending Payment</option>
                        </select>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold">Invoice Items</h3>
                        <button type="button" @click="addItem()" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">+ Add Item</button>
                    </div>

                    @if($patient)
                        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                            <div class="border rounded-md p-3">
                                <p class="font-semibold mb-2">Recent Appointments</p>
                                @forelse($appointments as $appt)
                                    <button
                                        type="button"
                                        class="w-full text-left mb-1 px-2 py-1 bg-gray-100 rounded hover:bg-gray-200"
                                        @click="addPreset('consultation', {{ $appt->id }}, 'Consultation - {{ $appt->appointment_date?->format('M d, Y H:i') }}', 1, {{ (float) $settings->default_consultation_fee }})"
                                    >
                                        + {{ $appt->appointment_date?->format('M d, Y H:i') }}
                                    </button>
                                @empty
                                    <p class="text-gray-500">No recent appointments.</p>
                                @endforelse
                            </div>
                            <div class="border rounded-md p-3">
                                <p class="font-semibold mb-2">Recent Lab Orders</p>
                                @forelse($labOrders as $order)
                                    <button
                                        type="button"
                                        class="w-full text-left mb-1 px-2 py-1 bg-gray-100 rounded hover:bg-gray-200"
                                        @click="addPreset('lab_test', {{ $order->id }}, 'Lab Order #{{ $order->id }}', 1, {{ (float) $settings->default_lab_test_fee }})"
                                    >
                                        + Lab Order #{{ $order->id }}
                                    </button>
                                @empty
                                    <p class="text-gray-500">No recent lab orders.</p>
                                @endforelse
                            </div>
                            <div class="border rounded-md p-3">
                                <p class="font-semibold mb-2">Recent Admissions</p>
                                @forelse($admissions as $admission)
                                    <button
                                        type="button"
                                        class="w-full text-left mb-1 px-2 py-1 bg-gray-100 rounded hover:bg-gray-200"
                                        @click="addPreset('room_charge', {{ $admission->id }}, 'Room charge - Admission #{{ $admission->id }}', 1, {{ (float) $settings->default_room_daily_fee }})"
                                    >
                                        + Admission #{{ $admission->id }}
                                    </button>
                                @empty
                                    <p class="text-gray-500">No recent admissions.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-2 mb-3 items-end border-b pb-3">
                            <div class="md:col-span-2">
                                <label class="text-xs text-gray-600">Type</label>
                                <select :name="`items[${index}][item_type]`" x-model="item.item_type" class="w-full border rounded-md px-2 py-1" required>
                                    <option value="consultation">Consultation</option>
                                    <option value="medicine">Medicine</option>
                                    <option value="lab_test">Lab Test</option>
                                    <option value="procedure">Procedure</option>
                                    <option value="room_charge">Room Charge</option>
                                    <option value="manual">Manual</option>
                                </select>
                            </div>
                            <div class="md:col-span-1">
                                <label class="text-xs text-gray-600">Ref ID</label>
                                <input type="number" min="1" :name="`items[${index}][item_id]`" x-model="item.item_id" class="w-full border rounded-md px-2 py-1">
                            </div>
                            <div class="md:col-span-4">
                                <label class="text-xs text-gray-600">Description</label>
                                <input type="text" :name="`items[${index}][description]`" x-model="item.description" class="w-full border rounded-md px-2 py-1" required>
                            </div>
                            <div class="md:col-span-1">
                                <label class="text-xs text-gray-600">Qty</label>
                                <input type="number" min="1" :name="`items[${index}][quantity]`" x-model.number="item.quantity" class="w-full border rounded-md px-2 py-1" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-xs text-gray-600">Unit Price</label>
                                <input type="number" step="0.01" min="0" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" class="w-full border rounded-md px-2 py-1" required>
                            </div>
                            <div class="md:col-span-1 text-sm font-semibold">
                                <label class="text-xs text-gray-600 block">Total</label>
                                <span x-text="format((item.quantity || 0) * (item.unit_price || 0))"></span>
                            </div>
                            <div class="md:col-span-1 text-right">
                                <button type="button" @click="removeItem(index)" class="text-red-600 text-sm">Remove</button>
                            </div>
                        </div>
                    </template>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Notes</label>
                            <textarea name="notes" rows="3" class="w-full border rounded-md px-3 py-2">{{ old('notes') }}</textarea>
                        </div>
                        <div class="bg-gray-50 rounded-md p-4 text-sm space-y-1">
                            <div class="flex justify-between"><span>Subtotal</span><span x-text="format(subtotal)"></span></div>
                            <div class="flex justify-between"><span>Discount</span><span x-text="format(discountAmount)"></span></div>
                            <div class="flex justify-between"><span>Tax</span><span x-text="format(taxAmount)"></span></div>
                            <div class="flex justify-between font-bold text-base border-t pt-2"><span>Total</span><span x-text="format(total)"></span></div>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-md">Save Invoice</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function invoiceForm() {
            return {
                taxRate: {{ old('tax_rate', $settings->tax_rate) }},
                discountType: '{{ old('discount_type', 'none') }}',
                discountValue: {{ old('discount_value', 0) }},
                items: [{ item_type: 'manual', item_id: '', description: '', quantity: 1, unit_price: 0 }],
                addItem() {
                    this.items.push({ item_type: 'manual', item_id: '', description: '', quantity: 1, unit_price: 0 });
                },
                addPreset(type, id, description, quantity, unitPrice) {
                    this.items.push({ item_type: type, item_id: id, description: description, quantity: quantity, unit_price: unitPrice });
                },
                removeItem(index) {
                    if (this.items.length === 1) return;
                    this.items.splice(index, 1);
                },
                get subtotal() {
                    return this.items.reduce((sum, item) => sum + ((item.quantity || 0) * (item.unit_price || 0)), 0);
                },
                get discountAmount() {
                    if (this.discountType === 'percentage') return this.subtotal * ((this.discountValue || 0) / 100);
                    if (this.discountType === 'fixed') return Math.min(this.subtotal, (this.discountValue || 0));
                    return 0;
                },
                get taxAmount() {
                    const taxable = Math.max(0, this.subtotal - this.discountAmount);
                    return taxable * ((this.taxRate || 0) / 100);
                },
                get total() {
                    return Math.max(0, this.subtotal - this.discountAmount + this.taxAmount);
                },
                format(number) {
                    return Number(number || 0).toFixed(2);
                }
            }
        }
    </script>
</x-app-layout>
