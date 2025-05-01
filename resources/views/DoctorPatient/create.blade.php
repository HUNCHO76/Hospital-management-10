<x-app-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Assign Doctor to Patient</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('doctor_patient.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="patient_id" class="form-label">Patient</label>
                                            <input type="hidden" name="pretest_id" id="patient_id" value="{{ $pretest->id }}">
                                            <input type="text" class="form-control" value="{{ $pretest->patient->full_name }}" readonly>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="doctor_id" class="form-label">Doctor</label>
                                        <select name="doctor_id" id="doctor_id" class="form-select">
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">
                                                    {{ $doctor->user->FirstName }} - {{ $doctor->specialization }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">Assign</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
