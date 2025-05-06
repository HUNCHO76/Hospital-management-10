<x-app-layout>
    <div class="container mt-5">
        <h4 class="mb-4">Check-up Form: Assign Diseases to Patient</h4>

        <form action="{{ route('checkup.store') }}" method="POST">
            @csrf
            <!-- Select Patient -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="pretest_id" class="form-label">Patient</label>
                    <input type="hidden" name="pretest_id" id="pretest_id" value="{{ $pretests->id }}">
                    <input type="text" class="form-control" value="{{ $pretests->patient->full_name }}" readonly>
                </div>
            </div>

            <!-- Select Doctor -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="doctor_id" class="form-label">Doctor Name</label>
                    @foreach ($doctors as $doctor)
                    <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctor->id }}">
                    <input type="text" class="form-control" value="{{ $doctor->user->FirstName }} {{ $doctor->user->LastName }} - {{ $doctor->specialization }}" readonly>
                    @endforeach
                </div>
            </div>
            <!-- Disease Entries -->
            <div id="diseases-container">
                <div class="row g-3 mb-3 disease-group">
                    <div class="col-md-6">
                        <label class="form-label">Disease</label>
                        <select name="diseases[0][name]" class="form-select disease-select" required>
                            <option value="" disabled selected>Select a disease</option>
                            @foreach($diseases as $disease)
                                <option value="{{ $disease->name }}">{{ $disease->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-disease">Remove</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary mb-3" id="add-disease">Add Another Disease</button>

            <!-- Notes -->
            {{-- <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="Enter any additional notes (optional)"></textarea>
            </div> --}}

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit Check-up</button>
            </div>
        </form>
    </div>

    <script>
        let diseaseIndex = 1; // Start indexing from 1 since the first group is already present

        document.getElementById('add-disease').addEventListener('click', function () {
            const container = document.getElementById('diseases-container');

            // Create a new disease group
            const group = document.createElement('div');
            group.classList.add('row', 'g-3', 'mb-3', 'disease-group');
            group.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label">Disease</label>
                    <select name="diseases[${diseaseIndex}][name]" class="form-select disease-select" required>
                        <option value="" disabled selected>Select a disease</option>
                        @foreach($diseases as $disease)
                            <option value="{{ $disease->name }}">{{ $disease->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-disease">Remove</button>
                </div>
            `;

            // Append the new group to the container
            container.appendChild(group);

            // Increment the index for the next group
            diseaseIndex++;

            // Update the dropdown options
            updateDiseaseOptions();
        });

        // Event delegation for removing disease groups
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-disease')) {
                e.target.closest('.disease-group').remove();
                updateDiseaseOptions();
            }
        });

        // Function to update disease options dynamically
        function updateDiseaseOptions() {
            const selectedDiseases = Array.from(document.querySelectorAll('.disease-select'))
                .map(select => select.value)
                .filter(value => value !== ""); // Get all selected diseases

            document.querySelectorAll('.disease-select').forEach(select => {
                const currentValue = select.value; // Preserve the current value
                select.innerHTML = `
                    <option value="" disabled ${currentValue === "" ? "selected" : ""}>Select a disease</option>
                    @foreach($diseases as $disease)
                        <option value="{{ $disease->name }}" ${selectedDiseases.includes('{{ $disease->name }}') && currentValue !== '{{ $disease->name }}' ? "disabled" : ""}>
                            {{ $disease->name }}
                        </option>
                    @endforeach
                `;
                select.value = currentValue; // Restore the current value
            });
        }

        // Initial call to update options
        updateDiseaseOptions();
    </script>
</x-app-layout>
