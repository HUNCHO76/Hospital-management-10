<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Checkup
            </h2>
            <a href="{{ route('checkup.show', $checkup->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Back to Details
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('checkup.update', $checkup->id) }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Patient</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 bg-gray-100" value="{{ $checkup->pretest?->patient?->full_name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Doctor</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 bg-gray-100" value="{{ $checkup->doctor?->user?->FirstName }} {{ $checkup->doctor?->user?->LastName }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="disease" class="block text-sm font-medium text-gray-700">Disease</label>
                            <select name="disease" id="disease" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 @error('disease') border-red-500 @enderror" required>
                                <option value="">Select Disease</option>
                                @foreach($diseases as $disease)
                                    <option value="{{ $disease->name }}" @selected(old('disease', $checkup->disease) === $disease->name)>
                                        {{ $disease->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('disease')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 @error('status') border-red-500 @enderror" required>
                                <option value="pending" @selected(old('status', $checkup->status) === 'pending')>Pending</option>
                                <option value="inprogress" @selected(old('status', $checkup->status) === 'inprogress')>In Progress</option>
                                <option value="completed" @selected(old('status', $checkup->status) === 'completed')>Completed</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if(strtolower(auth()->user()->Role ?? '') === 'doctor')
                            <div class="mb-4 border border-gray-200 rounded-md p-4 bg-gray-50 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Lab Orders</p>
                                    <p class="text-xs text-gray-500">Create lab orders for this consultation and patient.</p>
                                </div>
                                <a href="{{ route('doctor.lab-orders.create', ['checkup' => $checkup->id, 'patient_id' => $checkup->pretest?->patient_id]) }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    Order New Tests
                                </a>
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Update Checkup
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
