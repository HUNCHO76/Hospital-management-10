<x-app-layout>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Create New Prescription</h3>
                        <a href="{{ route('prescription.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('prescription.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="medical_record_id" class="form-label">Medical Record (Patient - Diagnosis)</label>
                                <select class="form-select" id="medical_record_id" name="medical_record_id" required>
                                    <option value="">Select Medical Record</option>
                                    @foreach($medicalRecords as $record)
                                        <option value="{{ $record->id }}" {{ old('medical_record_id') == $record->id ? 'selected' : '' }}>
                                            {{ $record->patient->full_name ?? 'Unknown Patient' }} - {{ $record->diagnosis ?? 'No Diagnosis' }} ({{ $record->visit_date ? $record->visit_date->format('Y-m-d') : 'No Date' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Select the associated medical record for this prescription.</div>
                            </div>

                            <div class="mb-3">
                                <label for="medication" class="form-label">Medication Name</label>
                                <input type="text" class="form-control" id="medication" name="medication" value="{{ old('medication') }}" required placeholder="e.g. Amoxicillin">
                            </div>

                            <div class="mb-3">
                                <label for="dosage" class="form-label">Dosage</label>
                                <input type="text" class="form-control" id="dosage" name="dosage" value="{{ old('dosage') }}" required placeholder="e.g. 500mg">
                            </div>
                            
                            <div class="mb-3">
                                <label for="instructions" class="form-label">Instructions</label>
                                <textarea class="form-control" id="instructions" name="instructions" rows="4" placeholder="e.g. Take one tablet twice daily after meals.">{{ old('instructions') }}</textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="mdi mdi-check"></i> Save Prescription
                                </button>
                                <a href="{{ route('prescription.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
