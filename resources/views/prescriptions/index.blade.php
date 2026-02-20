<x-app-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Prescriptions Management</h2>
            <a href="{{ route('prescription.create') }}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> Add Prescription
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search prescriptions...">
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Medication</th>
                        <th>Dosage</th>
                        <th>Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $prescription->medicalRecord?->patient?->full_name ?? 'N/A' }}</td>
                        <td>{{ $prescription->medicalRecord?->doctor?->user?->FirstName ?? 'N/A' }}</td>
                        <td>{{ $prescription->medication }}</td>
                        <td>{{ $prescription->dosage }}</td>
                        <td>{{ $prescription->created_at->format('M d, Y') }}</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm" type="button" id="actionMenu{{ $prescription->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $prescription->id }}">
                                    <li>
                                        <a href="{{ route('prescription.show', $prescription->id) }}" class="dropdown-item">View</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('prescription.edit', $prescription->id) }}" class="dropdown-item">Edit</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('prescription.destroy', $prescription->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No prescriptions available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $prescriptions->links() }}
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
