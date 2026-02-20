<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointment Details') }}
            </h2>
            <a href="{{ route('appointment.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Back to Appointments') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Patient</p>
                        <p class="mt-1 text-base text-gray-900">{{ $appointment->patient->full_name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Doctor</p>
                        <p class="mt-1 text-base text-gray-900">
                            {{ $appointment->doctor?->user?->FirstName }} {{ $appointment->doctor?->user?->LastName }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Date & Time</p>
                        <p class="mt-1 text-base text-gray-900">{{ $appointment->appointment_date?->format('M d, Y H:i') ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">End Time</p>
                        <p class="mt-1 text-base text-gray-900">{{ $appointment->end_time ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <span class="mt-1 px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if ($appointment->status === 'scheduled')
                                bg-blue-100 text-blue-800
                            @elseif ($appointment->status === 'completed')
                                bg-green-100 text-green-800
                            @else
                                bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Reason</p>
                        <p class="mt-1 text-base text-gray-900">{{ $appointment->reason ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($appointment->notes)
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-500">Notes</p>
                        <p class="mt-1 text-base text-gray-900 whitespace-pre-line">{{ $appointment->notes }}</p>
                    </div>
                @endif

                @if($appointment->status === 'cancelled' && $appointment->cancellation_reason)
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-md">
                        <p class="text-sm font-medium text-red-700">Cancellation Reason</p>
                        <p class="mt-1 text-base text-red-900">{{ $appointment->cancellation_reason }}</p>
                    </div>
                @endif
            </div>

            @if($appointment->bill)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Billing Information</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Bill Number</p>
                            <p class="mt-1 text-base text-gray-900">{{ $appointment->bill->bill_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Amount</p>
                            <p class="mt-1 text-base text-gray-900">{{ isset($appointment->bill->total_amount) ? number_format($appointment->bill->total_amount, 2) : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Payment Status</p>
                            <p class="mt-1 text-base text-gray-900">{{ ucfirst($appointment->bill->status ?? 'pending') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex gap-3">
                <a href="{{ route('appointment.edit', $appointment) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    {{ __('Edit Appointment') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
