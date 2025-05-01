<x-app-layout>
    <div class="container mt-4">
        <h2 class="mb-4">Pre-Test Management</h2>
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search pre-tests...">
        </div>
        {{-- <div class="table-responsive"> --}}
            <table class="table table-responsive table-striped custom-table ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>BP</th>
                        <th>Temp (°C)</th>
                        <th>Pulse</th>
                        <th>Respiration</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pre_tests as $preTest)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $preTest->patient->full_name }}</td>
                        <td>{{ $preTest->blood_pressure }}</td>
                        <td>{{ $preTest->temperature }}</td>
                        <td>{{ $preTest->pulse_rate }}</td>
                        <td>{{ $preTest->respiration_rate }}</td>
                        <td>
                            <!-- Action Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm" type="button" id="actionMenu{{ $preTest->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $preTest->id }}">
                                    <li>
                                        <a href="{{ route('doctor_patient.create', $preTest->id) }}" class="dropdown-item" style="color: black;">AssignDoctor</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pre_tests.edit', $preTest->id) }}" class="dropdown-item">Edit</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('pre_tests.delete', $preTest->id) }}" method="POST" class="d-inline">
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
                        <td colspan="7" class="text-center">No pre-test data available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        {{-- </div> --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $pre_tests->links() }}
        </div>
    </div>

    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastEl = document.querySelector('.toast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif

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
