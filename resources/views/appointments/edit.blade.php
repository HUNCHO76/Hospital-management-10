<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Appointment') }}
            </h2>
            <a href="{{ route('appointment.show', $appointment) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Back to Details') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('appointment.update', $appointment) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                            <select name="patient_id" id="patient_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('patient_id') border-red-500 @enderror" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ (old('patient_id', $appointment->patient_id) == $patient->id) ? 'selected' : '' }}>
                                        {{ $patient->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('doctor_id') border-red-500 @enderror" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ (old('doctor_id', $appointment->doctor_id) == $doctor->id) ? 'selected' : '' }}>
                                        {{ $doctor->user?->FirstName }} {{ $doctor->user?->LastName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700">Appointment Date & Time</label>
                            <input
                                type="datetime-local"
                                name="appointment_date"
                                id="appointment_date"
                                value="{{ old('appointment_date', $appointment->appointment_date ? $appointment->appointment_date->format('Y-m-d\TH:i') : '') }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('appointment_date') border-red-500 @enderror"
                                required
                            >
                            @error('appointment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input
                                type="time"
                                name="end_time"
                                id="end_time"
                                value="{{ old('end_time', $appointment->end_time ? substr($appointment->end_time, 0, 5) : '') }}"
                                step="60"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('end_time') border-red-500 @enderror"
                                required
                            >
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('status') border-red-500 @enderror" required>
                                <option value="scheduled" @selected(old('status', $appointment->status) === 'scheduled')>Scheduled</option>
                                <option value="completed" @selected(old('status', $appointment->status) === 'completed')>Completed</option>
                                <option value="cancelled" @selected(old('status', $appointment->status) === 'cancelled')>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                            <input
                                type="text"
                                name="reason"
                                id="reason"
                                value="{{ old('reason', $appointment->reason) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('reason') border-red-500 @enderror"
                                required
                            >
                            @error('reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea
                                name="notes"
                                id="notes"
                                rows="4"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 @error('notes') border-red-500 @enderror"
                            >{{ old('notes', $appointment->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                {{ __('Update Appointment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
