<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Checkup Details
            </h2>
            <div class="flex items-center gap-2">
                @if(strtolower(auth()->user()->Role ?? '') === 'doctor' && $checkup->pretest?->patient_id)
                    <a href="{{ route('doctor.patients.lab-results', $checkup->pretest->patient_id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        View Lab Results
                    </a>
                @endif
                <a href="{{ route('checkup.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to Checkups
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Checkup ID</p>
                        <p class="mt-1 text-base text-gray-900">{{ $checkup->id }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Patient</p>
                        <p class="mt-1 text-base text-gray-900">{{ $checkup->pretest?->patient?->full_name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Doctor</p>
                        <p class="mt-1 text-base text-gray-900">
                            {{ $checkup->doctor?->user?->FirstName }} {{ $checkup->doctor?->user?->LastName }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Disease</p>
                        <p class="mt-1 text-base text-gray-900">{{ $checkup->disease ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1 text-base text-gray-900">{{ ucfirst($checkup->status ?? 'pending') }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Created At</p>
                        <p class="mt-1 text-base text-gray-900">{{ $checkup->created_at ? $checkup->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                </div>

                @if($checkup->notes)
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-500">Notes</p>
                        <p class="mt-1 text-base text-gray-900 whitespace-pre-line">{{ $checkup->notes }}</p>
                    </div>
                @endif

                @if($checkup->differentialDiagnoses->isNotEmpty())
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-500 mb-2">Differential Diagnoses</p>
                        <div class="space-y-2">
                            @foreach($checkup->differentialDiagnoses->sortByDesc('availability_percentage') as $diagnosis)
                                <div class="flex items-center justify-between border rounded-md px-3 py-2">
                                    <span class="text-gray-900">{{ $diagnosis->disease_name }}</span>
                                    <span class="text-sm font-semibold text-indigo-700">{{ rtrim(rtrim(number_format($diagnosis->availability_percentage, 2), '0'), '.') }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
