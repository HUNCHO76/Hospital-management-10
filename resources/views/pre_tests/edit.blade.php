<x-app-layout>
    <div class="container mt-5">
        <h4 class="mb-4">Patient Pre-Test Form</h4>
        <form method="POST" action="{{ route('pre-tests.store') }}">
            @csrf
            <div class="row mb-3">
                <label for="patient_id" class="form-label">Patient</label>
                <select class="form-select" name="patient_id" id="patient_id" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->FullName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row mb-3">
                <label for="height" class="form-label">Height (cm)</label>
                <input type="number" step="0.01" name="height" id="height" class="form-control" required>
            </div>

            <div class="row mb-3">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" id="weight" class="form-control" required>
            </div>

            <div class="row mb-3">
                <label for="blood_pressure" class="form-label">Blood Pressure</label>
                <input type="text" name="blood_pressure" id="blood_pressure" class="form-control" placeholder="e.g., 120/80" required>
            </div>

            <div class="row mb-3">
                <label for="temperature" class="form-label">Temperature (°C)</label>
                <input type="number" step="0.1" name="temperature" id="temperature" class="form-control" required>
            </div>

            <div class="row mb-3">
                <label for="pulse_rate" class="form-label">Pulse Rate (bpm)</label>
                <input type="number" name="pulse_rate" id="pulse_rate" class="form-control" required>
            </div>

            <div class="row mb-3">
                <label for="respiration_rate" class="form-label">Respiration Rate</label>
                <input type="number" name="respiration_rate" id="respiration_rate" class="form-control" required>
            </div>

            <div class="row mb-4">
                <label for="notes" class="form-label">Additional Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Save Pre-Test</button>
            </div>
        </form>
    </div>
</x-app-layout>
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#patient_id').select2({
                placeholder: 'Select Patient',
                allowClear: true
            });
        });
    </script>
@endsection
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            line-height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            line-height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-top: 8px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 0 10px;
        }
    </style>
@endsection

