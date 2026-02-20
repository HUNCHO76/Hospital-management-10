<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order Lab Tests</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded-md">
                    <ul class="list-disc ml-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('doctor.lab-orders.store') }}" class="space-y-6">
                    @csrf

                    @if($checkup)
                        <input type="hidden" name="checkup_id" value="{{ $checkup->id }}">
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Patient</label>
                        <select name="patient_id" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" @selected(old('patient_id', $selectedPatientId) == $patient->id)>{{ $patient->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Available Lab Tests</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto border border-gray-200 rounded-lg p-4">
                            @foreach($labTests as $test)
                                <label class="flex items-start gap-3 p-3 rounded-md hover:bg-gray-50 border border-gray-100">
                                    <input type="checkbox" name="test_ids[]" value="{{ $test->id }}" class="mt-1" @checked(in_array($test->id, old('test_ids', [])))>
                                    <span class="text-sm">
                                        <span class="font-semibold text-gray-900">{{ $test->test_name }}</span>
                                        <span class="block text-gray-500">{{ $test->category }} | Ref: {{ $test->reference_range ?: 'N/A' }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Doctor Notes</label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3" placeholder="Additional instructions for lab technician...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('doctor.lab-orders.index') }}" class="px-4 py-2 bg-gray-200 rounded-md text-sm font-semibold">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold uppercase">Order Tests</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
