<x-app-layout>
    <div class="p-4 sm:p-6 lg:p-8 w-full">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Hospital Dashboard</h1>
                <p class="text-gray-600 mt-2">Welcome, {{ auth()->user()->FirstName }} {{ auth()->user()->LastName }}!</p>
                
                @if(strtolower(auth()->user()->Role ?? 'local') === 'local')
                    <div class="mt-6 bg-amber-50 border-l-4 border-amber-500 p-6 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-amber-800">Role Assignment Pending</h3>
                                <p class="mt-2 text-amber-700">
                                    Your account doesn't have a specific role assigned yet. Please contact your system administrator to assign you an appropriate role (Admin, Doctor, Nurse, Pharmacist, Receptionist, Lab Technician, or Cashier).
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Total Patients -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Patients</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ cache()->remember('patients_count', 3600, fn() => \App\Models\Patient::count()) }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM15 20H9m0 0h6m-6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Appointments Today -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Appointments Today</p>
                            @php
                                $todayAppointmentsQuery = \App\Models\Appointment::whereDate('appointment_date', now()->toDateString());
                                
                                // If user is a doctor, show only their appointments
                                if(auth()->user()->Role === 'doctor') {
                                    $doctor = \App\Models\Doctor::where('user_id', auth()->id())->first();
                                    if($doctor) {
                                        $todayAppointmentsQuery->where('doctor_id', $doctor->id);
                                    }
                                }
                                
                                $todayAppointmentsCount = $todayAppointmentsQuery->count();
                            @endphp
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $todayAppointmentsCount }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Admissions -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Active Admissions</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Admission::whereNull('discharge_date')->count() }}</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m5.581 0a2 2 0 10-5.162 0m5.162 0a2 2 0 01-5.162 0m0 0H4m16 0v-2.5a2.5 2.5 0 00-1.905-2.412M4 20v-2.5a2.5 2.5 0 011.905-2.412"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Medicines in Stock -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Medicines in Stock</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ cache()->remember('medicines_count', 3600, fn() => \App\Models\Medicine::count()) }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Upcoming Appointments -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="border-b border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900">Upcoming Appointments</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @php
                            $appointmentsQuery = \App\Models\Appointment::with('patient')->where('appointment_date', '>=', now());
                            
                            // If user is a doctor, show only their appointments
                            if(auth()->user()->Role === 'doctor') {
                                $doctor = \App\Models\Doctor::where('user_id', auth()->id())->first();
                                if($doctor) {
                                    $appointmentsQuery->where('doctor_id', $doctor->id);
                                }
                            }
                            
                            $upcomingAppointments = $appointmentsQuery->orderBy('appointment_date')->limit(5)->get();
                        @endphp
                        
                        @forelse($upcomingAppointments as $appointment)
                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ optional($appointment->patient)->full_name ?? 'Unknown Patient' }}</p>
                                        <p class="text-sm text-gray-500">{{ $appointment->reason ?? 'No reason specified' }}</p>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $appointment->appointment_date instanceof \Carbon\Carbon ? $appointment->appointment_date->format('M d, Y') : \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        </p>
                                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full 
                                            @if($appointment->status === 'scheduled') bg-blue-100 text-blue-800
                                            @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">No upcoming appointments</div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Admissions -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="border-b border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900">Recent Admissions</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse(\App\Models\Admission::with(['patient', 'room'])->orderBy('admission_date', 'desc')->limit(5)->get() as $admission)
                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ optional($admission->patient)->full_name ?? 'Unknown Patient' }}</p>
                                        <p class="text-sm text-gray-500">Room {{ optional($admission->room)->room_number ?? 'N/A' }}</p>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $admission->admission_date instanceof \Carbon\Carbon ? $admission->admission_date->format('M d, Y') : \Carbon\Carbon::parse($admission->admission_date)->format('M d, Y') }}
                                        </p>
                                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full 
                                            @if($admission->discharge_date) bg-green-100 text-green-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ $admission->discharge_date ? 'Discharged' : 'Active' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">No recent admissions</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Hospital Statistics -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900">Hospital Overview</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-200">
                    <div class="p-6 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ cache()->remember('doctors_count', 3600, fn() => \App\Models\Doctor::count()) }}</p>
                        <p class="text-sm text-gray-600">Doctors</p>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ cache()->remember('rooms_count', 3600, fn() => \App\Models\Room::count()) }}</p>
                        <p class="text-sm text-gray-600">Hospital Rooms</p>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ cache()->remember('departments_count', 3600, fn() => \App\Models\Department::count()) }}</p>
                        <p class="text-sm text-gray-600">Departments</p>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ cache()->remember('notifications_count', 300, fn() => \App\Models\Notification::count()) }}</p>
                        <p class="text-sm text-gray-600">Notifications</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>