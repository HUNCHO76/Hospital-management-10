<x-app-layout>
    <div class="container mt-4">
        <h2 class="mb-4">User Management</h2>
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
        </div>
        <table class="table table-striped custom-table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Reg No</th>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Occupation</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Payment Method</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->registration_no }}</td>
                    <td>{{ $data->FullName }}</td>
                    <td>{{ $data->age }}</td>
                    <td>{{ $data->gender }}</td>
                    <td>{{ $data->occupation }}</td>
                    <td>{{ $data->phone }}</td>
                    <td>{{ $data->country }}</td>
                    <td>{{ $data->payment_method }}</td>
                    <td>
                        <!-- Action Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm" type="button" id="actionMenu{{ $data->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $data->id }}">
                                <li>
                                    <a href="{{ route('patient.show', $data->id) }}" class="dropdown-item">View</a>
                                </li>
                                <li>
                                    <a href="{{ route('patient.edit', $data->id) }}" class="dropdown-item">Edit</a>
                                </li>
                                <li>
                                    <form action="{{ route('patient.delete', $data->id) }}" method="POST" class="d-inline">
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
            {{ $patients->links() }}
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
