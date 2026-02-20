<x-app-layout>
    <div class="container mt-5">
        <h4 class="mb-4">Clinical Check-up Form</h4>

        <form action="{{ route('checkup.store') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-info">
                <strong>Purpose:</strong> Capture one consultation record with a primary diagnosis and confidence-scored differential diagnoses.
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="pretest_id" class="form-label">Patient</label>
                    <input type="hidden" name="pretest_id" id="pretest_id" value="{{ $pretests->id }}">
                    <input type="text" class="form-control" value="{{ $pretests->patient->full_name }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Doctor</label>
                    <input type="text" class="form-control" value="{{ $doctor->user->FirstName }} {{ $doctor->user->LastName }} - {{ $doctor->specialization }}" readonly>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Clinical Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending" @selected(old('status') === 'pending')>Pending</option>
                        <option value="inprogress" @selected(old('status') === 'inprogress')>In Progress</option>
                        <option value="completed" @selected(old('status') === 'completed')>Completed</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="primary_disease" class="form-label">Primary Diagnosis</label>
                    <select name="primary_disease" id="primary_disease" class="form-select" required>
                        <option value="" disabled @selected(!old('primary_disease'))>Select primary diagnosis</option>
                        @foreach($diseases as $disease)
                            <option value="{{ $disease->name }}" @selected(old('primary_disease') === $disease->name)>{{ $disease->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3">Differential Diagnoses</h5>

            <div id="diseases-container">
                <div class="row g-3 mb-3 disease-group">
                    <div class="col-md-6">
                        <label class="form-label">Disease</label>
                        <select name="diseases[0][name]" class="form-select disease-select" required>
                            <option value="" disabled @selected(!old('diseases.0.name'))>Select a disease</option>
                            @foreach($diseases as $disease)
                                <option value="{{ $disease->name }}" @selected(old('diseases.0.name') === $disease->name)>{{ $disease->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Confidence (%)</label>
                        <input
                            type="number"
                            name="diseases[0][availability_percentage]"
                            class="form-control"
                            min="0"
                            max="100"
                            step="0.01"
                            value="{{ old('diseases.0.availability_percentage', 70) }}"
                            required
                        >
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-disease">Remove</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-outline-primary mb-3" id="add-disease">Add Differential Disease</button>

            @if(strtolower(auth()->user()->Role ?? '') === 'doctor')
                <div class="mb-3">
                    <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Lab Orders</h6>
                            <p class="mb-0 text-muted small">Order laboratory investigations for this patient during this consultation.</p>
                        </div>
                        <a href="{{ route('doctor.lab-orders.create', ['patient_id' => $pretests->patient_id]) }}" class="btn btn-outline-primary btn-sm">
                            Order New Tests
                        </a>
                    </div>
                </div>
            @endif

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Save Check-up</button>
            </div>
        </form>
    </div>

    <script>
        let diseaseIndex = 1;

        document.getElementById('add-disease').addEventListener('click', function () {
            const container = document.getElementById('diseases-container');
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
                <div class="col-md-3">
                    <label class="form-label">Confidence (%)</label>
                    <input type="number" name="diseases[${diseaseIndex}][availability_percentage]" class="form-control" min="0" max="100" step="0.01" value="70" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-disease">Remove</button>
                </div>
            `;

            container.appendChild(group);
            diseaseIndex++;
            updateDiseaseOptions();
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-disease')) {
                const groups = document.querySelectorAll('.disease-group');
                if (groups.length === 1) {
                    alert('At least one differential diagnosis is required.');
                    return;
                }

                e.target.closest('.disease-group').remove();
                updateDiseaseOptions();
            }
        });

        function updateDiseaseOptions() {
            const selectedDiseases = Array.from(document.querySelectorAll('.disease-select'))
                .map(select => select.value)
                .filter(value => value !== '');

            document.querySelectorAll('.disease-select').forEach(select => {
                const currentValue = select.value;
                select.innerHTML = `
                    <option value="" disabled ${currentValue === '' ? 'selected' : ''}>Select a disease</option>
                    @foreach($diseases as $disease)
                        <option value="{{ $disease->name }}" ${selectedDiseases.includes('{{ $disease->name }}') && currentValue !== '{{ $disease->name }}' ? 'disabled' : ''}>
                            {{ $disease->name }}
                        </option>
                    @endforeach
                `;
                select.value = currentValue;
            });
        }

        updateDiseaseOptions();
    </script>
</x-app-layout>
