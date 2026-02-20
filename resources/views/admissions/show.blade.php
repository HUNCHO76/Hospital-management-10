<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admission Details
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admission.edit', $admission->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('admission.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Patient Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Patient Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Patient Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $admission->patient->full_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Registration Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $admission->patient->registration_no }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $admission->patient->email ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $admission->patient->mobile_phone ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Room Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Room Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Room Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $admission->room->room_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Room Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $admission->room->room_type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Room Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $admission->room->status === 'occupied' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($admission->room->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Admission Details -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Admission Details</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Admission Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($admission->admission_date)->format('M d, Y h:i A') }}
                                    </dd>
                                </div>
                                
                                @if($admission->discharge_date)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Discharge Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($admission->discharge_date)->format('M d, Y h:i A') }}
                                    </dd>
                                </div>
                                @endif

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @if($admission->discharge_date)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Discharged
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Active
                                            </span>
                                        @endif
                                    </dd>
                                </div>

                                @if($admission->notes)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $admission->notes }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Delete Button -->
                    @if(!$admission->discharge_date)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('admission.destroy', $admission->id) }}" onsubmit="return confirm('Are you sure you want to delete this admission?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Delete Admission
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
