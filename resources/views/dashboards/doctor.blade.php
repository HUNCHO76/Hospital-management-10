<x-app-layout>
    <div class="w-full px-4 md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto py-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8 font-sans">Doctor Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-indigo-500">
                    <p class="text-gray-500 uppercase text-xs font-bold">Appointments Today</p>
                    <p class="text-2xl font-bold font-mono">{{ $stats['appointments_today'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                    <p class="text-gray-500 uppercase text-xs font-bold">Total Assigned Patients</p>
                    <p class="text-2xl font-bold font-mono">{{ $stats['total_patients'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-500 font-sans">
                    <p class="text-gray-500 uppercase text-xs font-bold">Pending Appointments</p>
                    <p class="text-2xl font-bold font-mono">{{ $stats['pending_appointments'] }}</p>
                </div>
            </div>

            <!-- Doctor specific sections here -->
             <div class="mt-12 bg-white rounded-lg shadow p-8 font-sans">
                <h2 class="text-xl font-bold mb-4">Patient Management</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('assigned_patients') }}" class="p-6 bg-blue-50 hover:bg-blue-100 rounded text-center font-bold text-blue-700 transition">View Patient List</a>
                    <a href="#" class="p-6 bg-green-50 hover:bg-green-100 rounded text-center font-bold text-green-700 transition">Write Prescriptions</a>
                    <a href="#" class="p-6 bg-purple-50 hover:bg-purple-100 rounded text-center font-bold text-purple-700 transition">Order Lab Tests</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>