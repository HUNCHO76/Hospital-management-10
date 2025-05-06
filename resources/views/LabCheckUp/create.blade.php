<x-app-layout>
    <div class="container mt-5">
        <h4 class="mb-4">Add Test Results for Patient</h4>

        <form action="{{ route('lab.store') }}" method="POST">
            @csrf
            
            @foreach($patients as $disease)
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Patient Name {{ $disease->patient->full_name }}</label>
                        <input type="hidden" name="patient_id" value="{{ $disease->patient_id }}">
                        <input type="hidden" name="checkup_id" value="{{ $disease->id }}">
                        <input type="text" class="form-control" value="{{ $disease->patient->full_name }}" readonly>
                    </div>
                </div>
            </div>

            <div id="results-container">
                <div class="row g-3 mb-3 result-group">
                    <div class="col-md-5">
                        <label class="form-label">Disease</label>
                        <input type="text" name="results[0][disease]" class="form-control" value="{{ $disease->disease }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="results[0][status]" class="form-select" required>
                            <option value="" disabled selected>Pending</option>
                            <option value="Positive">Positive</option>
                            <option value="Negative">Negative</option>
                            {{-- <option value="Pending">Pending</option> --}}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Percentage (%)</label>
                        <input type="number" name="results[0][percentage]" class="form-control" min="0" max="100" placeholder="e.g., 75">
                    </div>
                </div>
            </div>
            @endforeach

            <button type="button" class="btn btn-secondary mb-3" id="add-result">Add Another Test</button>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit Results</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let resultIndex = 1;
            const container = document.getElementById('results-container');
            const addButton = document.getElementById('add-result');
            const patientId = document.querySelector('input[name="patient_id"]').value;
            const checkupId = document.querySelector('input[name="checkup_id"]').value;

            // Add new test result
            addButton.addEventListener('click', async function() {
                // You might want to fetch available diseases for this patient
                // Here's a simple implementation with a text input
                const group = document.createElement('div');
                group.classList.add('row', 'g-3', 'mb-3', 'result-group');
                group.innerHTML = `
                    <div class="col-md-5">
                        <label class="form-label">Disease</label>
                        <input type="text" name="results[${resultIndex}][disease]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="results[${resultIndex}][status]" class="form-select" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="Positive">Positive</option>
                            <option value="Negative">Negative</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Percentage (%)</label>
                        <input type="number" name="results[${resultIndex}][percentage]" class="form-control" min="0" max="100" placeholder="e.g., 75">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Remarks</label>
                        <textarea name="results[${resultIndex}][remarks]" class="form-control" rows="1" placeholder="Optional"></textarea>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-result">Remove</button>
                    </div>
                `;
                container.appendChild(group);
                resultIndex++;
            });

            // Remove test result
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-result')) {
                    e.target.closest('.result-group').remove();
                    // Reindex remaining results if needed
                }
            });
        });
    </script>
    @endpush
</x-app-layout>