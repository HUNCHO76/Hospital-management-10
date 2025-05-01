<!-- filepath: c:\xampp\htdocs\Hospital-management-10\resources\views\DoctorPatient\index.blade.php -->
<x-app-layout>
    <div class="container mt-4">
        <h2 class="mb-4">Doctor-Patient Management</h2>
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search doctor-patient assignments...">
        </div>
        <table class="table table-striped custom-table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Specialization</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctorPatients as $assignment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $assignment->pretest->patient->full_name }}</td>
                    <td>{{ $assignment->doctor->user->FirstName }} {{ $assignment->doctor->user->LastName }}</td>
                    <td>{{ $assignment->doctor->specialization }}</td>
                    <td>
                        <!-- Action Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm" type="button" id="actionMenu{{ $assignment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $assignment->id }}">
                                <li>
                                    <a href="{{ route('doctor_patient.show', $assignment->id) }}" class="dropdown-item">View</a>
                                </li>
                                <li>
                                    <a href="{{ route('doctor_patient.edit', $assignment->id) }}" class="dropdown-item">Edit</a>
                                </li>
                                <li>
                                    <form action="{{ route('doctor_patient.delete', $assignment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $doctorPatients->links() }}
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
