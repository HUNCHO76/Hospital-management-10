<x-app-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Pre-Test Management</h2>
            <!-- Optional: Add a button to create a new pre-test directly -->
            <a href="{{ route('pre_tests.create') }}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> New Pre-Test
            </a>
        </div>

        <!-- Search -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by patient name or vitals...">
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Height</th>
                        <th>Weight</th>
                        <th>BP</th>
                        <th>Temp (°C)</th>
                        <th>Pulse</th>
                        <th>Respiration</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignedPatients as $assignment)
                        @php
                            $pretest = $assignment->pretest; // may be null
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pretest?->patient?->full_name ?? 'N/A' }}</td>
                            <td>{{ $pretest?->height ?? '-' }} cm</td>
                            <td>{{ $pretest?->weight ?? '-' }} kg</td>
                            <td>{{ $pretest?->blood_pressure ?? '-' }}</td>
                            <td>{{ $pretest?->temperature ?? '-' }} °C</td>
                            <td>{{ $pretest?->pulse_rate ?? '-' }}</td>
                            <td>{{ $pretest?->respiration_rate ?? '-' }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($pretest)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('checkup.create', $pretest->id) }}">
                                                    <i class="mdi mdi-stethoscope me-2"></i>CheckUp
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('checkup.edit', $assignment->id) }}">
                                                    <i class="mdi mdi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('checkup.delete', $assignment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pre‑test?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="mdi mdi-delete me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item" href="{{ route('pre_tests.create', ['assignment_id' => $assignment->id]) }}">
                                                    <i class="mdi mdi-plus-circle me-2"></i>Add Pre-Test
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No patient assignments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $assignedPatients->links() }}
        </div>
    </div>

    <!-- Success Toast -->
    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastEl = document.getElementById('successToast');
                if (toastEl) {
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                }
            });
        </script>
    @endif

    <!-- Simple client-side search -->
    <script>
        document.getElementById('searchInput')?.addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>