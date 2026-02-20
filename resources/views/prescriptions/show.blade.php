<x-app-layout>
    <div class="container mt-4">
        <div class="row"></div>
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Prescription Details</h3>
                        <a href="{{ route('prescription.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="text-secondary border-bottom pb-2">Patient Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Patient Name:</strong>
                                    <p>{{ $prescription->medicalRecord->patient->full_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Doctor:</strong>
                                    <p>Dr. {{ $prescription->medicalRecord->doctor->user->name ?? $prescription->medicalRecord->doctor->user->FirstName ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-secondary border-bottom pb-2">Prescription Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Medication:</strong>
                                    <p class="fs-5">{{ $prescription->medication }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Dosage:</strong>
                                    <p class="fs-5">{{ $prescription->dosage }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Instructions:</strong>
                                <div class="p-3 bg-light rounded border">
                                    {{ $prescription->instructions ?? 'No instructions provided.' }}
                                </div>
                            </div>

                            <div class="row text-muted small">
                                <div class="col-md-6">
                                    Created: {{ $prescription->created_at->format('M d, Y H:i A') }}
                                </div>
                                <div class="col-md-6 text-end">
                                    Last Updated: {{ $prescription->updated_at->format('M d, Y H:i A') }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('prescription.edit', $prescription->id) }}" class="btn btn-warning">
                                <i class="mdi mdi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('prescription.destroy', $prescription->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this prescription?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="mdi mdi-delete"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
