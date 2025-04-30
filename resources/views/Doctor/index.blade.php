<x-app-layout>
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

<div class="container mt-4">
    <h2>Doctor List</h2>
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search doctors...">
    </div>
    <table class="table table-bordered table-striped custom-table datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Specialization</th>
                <th>Qualification</th>
                <th>Department</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors as $doctor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $doctor->user->FirstName }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->qualification }}</td>
                    <td>{{ $doctor->department->name }}</td>
                    <td>{{ $doctor->phone }}</td>
                    <td>{{ $doctor->address }}</td>
                    <td>
                        <!-- Action Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm" type="button" id="actionMenu{{ $doctor->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $doctor->id }}">
                                <li>
                                    <a href="{{ route('doctor.show', $doctor->id) }}" class="dropdown-item">View</a>
                                </li>
                                <li>
                                    <a href="{{ route('doctor.edit', $doctor->id) }}" class="dropdown-item">Edit</a>
                                </li>
                                <li>
                                    <form action="{{ route('doctor.delete', $doctor->id) }}" method="POST" class="d-inline">
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
