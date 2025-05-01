<x-app-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Patient Pre-Test Form</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pre_tests.store') }}">
                            @csrf
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="patient_id" class="form-label">Patient</label>
                                        <input type="hidden" name="patient_id" id="patient_id" value="{{ $patient->id }}">
                                        <input type="text" class="form-control" value="{{ $patient->full_name }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="height" class="form-label">Height (cm)</label>
                                        <input type="number" step="0.01" name="height" id="height" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="weight" class="form-label">Weight (kg)</label>
                                        <input type="number" step="0.01" name="weight" id="weight" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="blood_pressure" class="form-label">Blood Pressure</label>
                                        <input type="text" name="blood_pressure" id="blood_pressure" class="form-control" placeholder="e.g., 120/80" required>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="temperature" class="form-label">Temperature (°C)</label>
                                        <input type="number" step="0.1" name="temperature" id="temperature" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pulse_rate" class="form-label">Pulse Rate (bpm)</label>
                                        <input type="number" name="pulse_rate" id="pulse_rate" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="respiration_rate" class="form-label">Respiration Rate</label>
                                        <input type="number" name="respiration_rate" id="respiration_rate" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Additional Notes</label>
                                        <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">Save Pre-Test</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
