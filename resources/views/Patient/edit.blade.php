<x-app-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Patient</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('patient.update', $patient->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="registration_no" class="form-label">Registration No</label>
                                        <input type="text" name="registration_no" class="form-control @error('registration_no') is-invalid @enderror" id="registration_no" placeholder="Enter Registration No" value="{{ old('registration_no', $patient->registration_no) }}">
                                        @error('registration_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="FullName" class="form-label">Full Name</label>
                                        <input type="text" name="FullName" class="form-control @error('FullName') is-invalid @enderror" id="FullName" placeholder="Enter Full Name" value="{{ old('FullName', $patient->FullName) }}">
                                        @error('FullName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="age" class="form-label">Age</label>
                                        <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" id="age" placeholder="Enter Age" value="{{ old('age', $patient->age) }}">
                                        @error('age')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="marital_status" class="form-label">Marital Status</label>
                                        <input type="text" name="marital_status" class="form-control @error('marital_status') is-invalid @enderror" id="marital_status" placeholder="Enter Marital Status" value="{{ old('marital_status', $patient->marital_status) }}">
                                        @error('marital_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter Phone Number" value="{{ old('phone', $patient->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="occupation" class="form-label">Occupation</label>
                                        <input type="text" name="occupation" class="form-control @error('occupation') is-invalid @enderror" id="occupation" placeholder="Enter Occupation" value="{{ old('occupation', $patient->occupation) }}">
                                        @error('occupation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-select @error('country') is-invalid @enderror" name="country" id="country">
                                            <option value="local" {{ old('country', $patient->country) == 'local' ? 'selected' : '' }}>Local</option>
                                            <option value="nurse" {{ old('country', $patient->country) == 'nurse' ? 'selected' : '' }}>Nurse</option>
                                            <option value="doctor" {{ old('country', $patient->country) == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                            <option value="admin" {{ old('country', $patient->country) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="receptionist" {{ old('country', $patient->country) == 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                                            <option value="pharmacist" {{ old('country', $patient->country) == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                            <option value="labtechnician" {{ old('country', $patient->country) == 'labtechnician' ? 'selected' : '' }}>Lab Technician</option>
                                            <option value="accountant" {{ old('country', $patient->country) == 'accountant' ? 'selected' : '' }}>Accountant</option>
                                            <option value="hr" {{ old('country', $patient->country) == 'hr' ? 'selected' : '' }}>HR</option>
                                            <option value="radiologist" {{ old('country', $patient->country) == 'radiologist' ? 'selected' : '' }}>Radiologist</option>
                                            <option value="physiotherapist" {{ old('country', $patient->country) == 'physiotherapist' ? 'selected' : '' }}>Physiotherapist</option>
                                            <option value="dietitian" {{ old('country', $patient->country) == 'dietitian' ? 'selected' : '' }}>Dietitian</option>
                                            <option value="technician" {{ old('country', $patient->country) == 'technician' ? 'selected' : '' }}>Technician</option>
                                        </select>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method" id="payment_method">
                                            <option value="1" {{ old('payment_method', $patient->payment_method) == '1' ? 'selected' : '' }}>Cash</option>
                                            <option value="0" {{ old('payment_method', $patient->payment_method) == '0' ? 'selected' : '' }}>Card</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('patient.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
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
</x-app-layout>
