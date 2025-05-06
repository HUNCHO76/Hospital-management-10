<!-- filepath: c:\xampp\htdocs\Hospital-management-10\resources\views\checkup\index.blade.php -->
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
        <h2>Checkup List</h2>
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search checkups...">
        </div>
        <table class="table table-bordered table-striped custom-table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Disease</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkups as $checkup)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $checkup->pretest_id }}</td>
                        <td>{{ $checkup->doctor->user->FirstName }} {{ $checkup->doctor->user->LastName }}</td>
                        <td>{{ $checkup->disease }}</td>
                        <td>
                            <span class="badge
                                @if($checkup->status == 'pending') bg-warning
                                @elseif($checkup->status == 'positive') bg-success
                                @elseif($checkup->status == 'negative') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ $checkup->status }}
                            </span>
                        </td>
                        <td>
                            <!-- Action Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm" type="button" id="actionMenu{{ $checkup->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $checkup->id }}">
                                    <li>
                                        <a href="{{ route('checkup.show', $checkup->id) }}" class="dropdown-item">View</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('checkup.edit', $checkup->id) }}" class="dropdown-item">Edit</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('checkup.delete', $checkup->id) }}" method="POST" class="d-inline">
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
