<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Admission
            </h2>
            <a href="{{ route('admission.show', $admission->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Back to Details
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admission.update', $admission->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                            <select name="patient_id" id="patient_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('patient_id') border-red-500 @enderror" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ (old('patient_id', $admission->patient_id) == $patient->id) ? 'selected' : '' }}>
                                        {{ $patient->full_name }} - {{ $patient->registration_no }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="room_id" class="block text-sm font-medium text-gray-700">Room</label>
                            <select name="room_id" id="room_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('room_id') border-red-500 @enderror" required>
                                <option value="">Select Room</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ (old('room_id', $admission->room_id) == $room->id) ? 'selected' : '' }}>
                                        Room {{ $room->room_number }} - {{ $room->room_type }} 
                                        @if($room->status === 'occupied' && $room->id !== $admission->room_id)
                                            (Occupied)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="admission_date" class="block text-sm font-medium text-gray-700">Admission Date</label>
                            <input type="datetime-local" name="admission_date" id="admission_date" 
                                   value="{{ old('admission_date', \Carbon\Carbon::parse($admission->admission_date)->format('Y-m-d\TH:i')) }}" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('admission_date') border-red-500 @enderror" required>
                            @error('admission_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="discharge_date" class="block text-sm font-medium text-gray-700">Discharge Date (Optional)</label>
                            <input type="datetime-local" name="discharge_date" id="discharge_date" 
                                   value="{{ old('discharge_date', $admission->discharge_date ? \Carbon\Carbon::parse($admission->discharge_date)->format('Y-m-d\TH:i') : '') }}" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('discharge_date') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Leave blank if patient is still admitted</p>
                            @error('discharge_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('notes') border-red-500 @enderror">{{ old('notes', $admission->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Update Admission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
