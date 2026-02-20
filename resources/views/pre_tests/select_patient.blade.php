<x-app-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Select Patient for Pre-Test</h4>
                    </div>
                    <div class="card-body">
                        @if($patients->isEmpty())
                            <div class="alert alert-info">
                                No patients found. Please register a patient first.
                            </div>
                            <a href="{{ route('patient.index') }}" class="btn btn-primary">Go to Patients</a>
                        @else
                            <div class="mb-3">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search by name or registration number...">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Registration No</th>
                                            <th>Full Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="patientTable">
                                        @foreach($patients as $patient)
                                            <tr>
                                                <td>{{ $patient->registration_no }}</td>
                                                <td>{{ $patient->full_name }}</td>
                                                <td>{{ $patient->age ?? 'N/A' }}</td>
                                                <td>{{ $patient->gender ?? 'N/A' }}</td>
                                                <td>{{ $patient->phone ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('pre_tests.create', $patient->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-heartbeat"></i> Pre-Test
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput')?.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#patientTable tr');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
