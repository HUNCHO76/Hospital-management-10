<aside class="w-full bg-gray-900 text-white h-full overflow-y-auto flex flex-col sticky top-0 transition-all duration-300">
    <!-- Logo area -->
    <div class="p-6 border-b border-gray-700">
        <h2 class="text-2xl font-bold tracking-tight">Hospital</h2>
        <p class="text-gray-400 text-sm mt-1">Management System</p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
        @php
            $userRole = strtolower(auth()->user()->Role ?? '');
            $dashboardRoute = match($userRole) {
                'lab technician', 'lab_technician' => 'lab.dashboard.role',
                default => $userRole . '.dashboard',
            };

            $doctorLabUnreadCount = 0;
            $labPendingCount = 0;
            $cashierPendingInvoicesCount = 0;

            if ($userRole === 'doctor') {
                $doctorId = \App\Models\Doctor::where('user_id', auth()->id())->value('id');
                if ($doctorId) {
                    $doctorLabUnreadCount = \App\Models\LabOrder::where('doctor_id', $doctorId)
                        ->where('status', 'completed')
                        ->whereNull('viewed_at')
                        ->count();
                }
            }

            if (in_array($userRole, ['lab technician', 'lab_technician'])) {
                $labPendingCount = \App\Models\LabOrder::where('status', 'pending')->count();
            }

            if ($userRole === 'cashier') {
                $cashierPendingInvoicesCount = \App\Models\Invoice::whereIn('status', ['pending', 'partially_paid'])->count();
            }
        @endphp

        <!-- Dashboard (role‑specific route) -->
        <a href="{{ route($dashboardRoute) }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs($dashboardRoute) || request()->routeIs($userRole . '.dashboard') ? 'bg-indigo-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="font-bold uppercase text-xs tracking-widest">Dashboard</span>
        </a>

        @if($userRole == 'admin')
            <!-- Admin Menu -->
            <div x-data="{ open: {{ request()->routeIs('admin.*') || request()->routeIs('department.*') || request()->routeIs('room.*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        </svg>
                        <span class="font-bold uppercase text-xs tracking-widest">Administration</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-4 space-y-1 border-l border-gray-700 ml-6">
                    <a href="{{ route('admin.index.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('admin.index.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        👥 User Management
                    </a>
                    <a href="{{ route('department.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('department.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🏥 Departments
                    </a>
                    <a href="{{ route('room.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('room.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🏨 Rooms & Beds
                    </a>
                    <a href="{{ route('admin.lab-tests.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('admin.lab-tests.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🧪 Lab Test Catalog
                    </a>
                    <a href="{{ route('admin.billing.settings.edit') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('admin.billing.settings.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        ⚙️ Billing Settings
                    </a>
                    <a href="{{ route('admin.billing.reports.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('admin.billing.reports.index') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        📈 Billing Reports
                    </a>
                    <a href="{{ route('admin.billing.insurance-claims.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('admin.billing.insurance-claims.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🏥 Insurance Claims
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        ⚙️ System Config
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        🔐 Audit Logs
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📈 System Reports
                    </a>
                </div>
            </div>
        @endif

        @if($userRole == 'receptionist')
            <!-- Reception Menu -->
            <div x-data="{ open: {{ request()->routeIs('patient.*') || request()->routeIs('appointment.*') || request()->routeIs('admission.*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m5.581 0a2 2 0 10-5.162 0m5.162 0a2 2 0 01-5.162 0m0 0H4m16 0v-2.5a2.5 2.5 0 00-1.905-2.412M4 20v-2.5a2.5 2.5 0 011.905-2.412"></path>
                        </svg>
                        <span class="font-bold uppercase text-xs tracking-widest">Reception</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-4 space-y-1 border-l border-gray-700 ml-6">
                    <a href="{{ route('patient.create') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('patient.create') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        ➕ Register Patient
                    </a>
                    <a href="{{ route('patient.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('patient.index') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        👥 Patient Search
                    </a>
                    <a href="{{ route('appointment.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('appointment.index') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        📅 Appointments
                    </a>
                    <a href="{{ route('admission.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('admission.index') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🏥 Admissions
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📋 Reports
                    </a>
                </div>
            </div>
        @endif

        @if($userRole == 'doctor')
            <!-- Doctor Menu -->
            <div x-data="{ open: true }" class="space-y-1">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-bold uppercase text-xs tracking-widest">Medical</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-4 space-y-1 border-l border-gray-700 ml-6">
                    <a href="{{ route('appointment.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('appointment.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        📅 My Appointments
                    </a>
                    <a href="{{ route('assigned_patients') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('assigned_patients') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        👥 My Patients
                    </a>
                    <a href="{{ route('checkup.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('checkup.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🩺 Consultations
                    </a>
                    <a href="{{ route('prescription.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('prescription.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        💊 Prescriptions
                    </a>
                    <a href="{{ route('doctor.lab-orders.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('doctor.lab-orders.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🧪 Lab Orders
                        @if($doctorLabUnreadCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $doctorLabUnreadCount }}</span>
                        @endif
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📄 Medical Records
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        🏥 Discharge Notes
                    </a>
                </div>
            </div>
        @endif

        @if($userRole == 'nurse')
            <!-- Nurse Menu -->
            <div x-data="{ open: true }" class="space-y-1">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="font-bold uppercase text-xs tracking-widest">Patient Care</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-4 space-y-1 border-l border-gray-700 ml-6">
                    <a href="{{ route('room.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('room.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🏥 Ward Assignment
                    </a>
                    <a href="{{ route('patient.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('patient.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        👥 Patients in Ward
                    </a>
                    <a href="{{ route('pre_tests.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('pre_tests.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🌡️ Vitals Entry
                    </a>
                    <a href="{{ route('prescription.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('prescription.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        💉 Medication Admin
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📝 Care Notes
                    </a>
                    <a href="{{ route('admission.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('admission.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🚑 Admissions/Discharge
                    </a>
                </div>
            </div>
        @endif

        @if($userRole == 'pharmacist')
            <!-- Pharmacist Menu -->
            <div x-data="{ open: true }" class="space-y-1">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        <span class="font-bold uppercase text-xs tracking-widest">Pharmacy</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-4 space-y-1 border-l border-gray-700 ml-6">
                    <a href="{{ route('prescription.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('prescription.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        💊 Prescriptions
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📦 Inventory
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        ➕ Add Medicine
                    </a>
                    <a href="{{ route('bill.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('bill.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        💰 Billing Integration
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📋 Reports
                    </a>
                </div>
            </div>
        @endif

        @if($userRole == 'lab technician' || $userRole == 'lab_technician')
            <!-- Lab Menu -->
            <div x-data="{ open: true }" class="space-y-1">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span class="font-bold uppercase text-xs tracking-widest">Laboratory</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-4 space-y-1 border-l border-gray-700 ml-6">
                    <a href="{{ route('labtech.pending') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('labtech.pending') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🧪 Pending Orders
                        @if($labPendingCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $labPendingCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('labtech.completed') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('labtech.completed') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        ✅ Completed Orders
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📤 Upload Reports
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📋 Test Catalog
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        🔬 Quality Control
                    </a>
                </div>
            </div>
        @endif

        @if($userRole == 'cashier')
            <!-- Cashier/Accountant Menu -->
            <div x-data="{ open: true }" class="space-y-1">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="font-bold uppercase text-xs tracking-widest">Billing</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-4 space-y-1 border-l border-gray-700 ml-6">
                    <a href="{{ route('cashier.billing-dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('cashier.billing-dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        🏠 Dashboard
                    </a>
                    <a href="{{ route('cashier.invoices.create') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('cashier.invoices.create') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        💰 Generate Invoice
                    </a>
                    <a href="{{ route('cashier.billing-queue') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('cashier.billing-queue') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        📋 Billing Queue
                        @if($cashierPendingInvoicesCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cashierPendingInvoicesCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('cashier.reports.daily') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('cashier.reports.daily') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        📊 Daily Report
                    </a>
                    <a href="{{ route('cashier.reports.monthly') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('cashier.reports.monthly') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        📈 Monthly Report
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        💳 Record Payment
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        🏥 Insurance Claims
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        📊 Financial Reports
                    </a>
                </div>
            </div>
        @endif

        @if($userRole == 'patient')
            <!-- Patient Menu -->
            <div x-data="{ open: true }" class="space-y-1">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-bold uppercase text-xs tracking-widest">My Portal</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-4 space-y-1 border-l border-gray-700 ml-6">
                    <a href="{{ route('appointment.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('appointment.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        📅 My Appointments
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        🩺 Medical Records
                    </a>
                    <a href="{{ route('bill.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition {{ request()->routeIs('bill.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        💳 Billing & Payments
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-xs uppercase font-bold tracking-tighter rounded-lg transition text-gray-400 hover:bg-gray-800 hover:text-white">
                        ✍️ Feedback
                    </a>
                </div>
            </div>
        @endif

        <!-- Messages (common for all staff) -->
        @if(in_array($userRole, ['admin','receptionist','doctor','nurse','pharmacist','lab_technician','cashier']))
        <a href="#" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition text-gray-300 hover:bg-gray-800 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <span class="font-bold uppercase text-xs tracking-widest">Messages</span>
            @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $unreadMessagesCount }}</span>
            @endif
        </a>
        @endif

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('profile.edit') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="font-bold uppercase text-xs tracking-widest">Profile</span>
        </a>
    </nav>

    <!-- Footer with user info -->
    <div class="mt-auto px-6 py-4 border-t border-gray-700">
        <p class="text-xs text-gray-400 break-words">Logged in as: <span class="font-semibold text-white">{{ Auth::user()->FirstName ?? Auth::user()->name }}</span></p>
    </div>
</aside>