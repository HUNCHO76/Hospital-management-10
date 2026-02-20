<x-app-layout>
    <div class="w-full px-4 md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto py-8">
            <h1 class="text-3xl font-bold font-sans text-gray-900 mb-8">Receptionist Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                    <p class="text-gray-500 uppercase text-xs font-bold font-sans">Registered Today</p>
                    <p class="text-3xl font-extrabold font-mono text-blue-600">{{ $stats['patients_registered_today'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-emerald-500">
                    <p class="text-gray-500 uppercase text-xs font-bold font-sans">Booked Today</p>
                    <p class="text-3xl font-extrabold font-mono text-emerald-600">{{ $stats['appointments_booked_today'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-amber-500 font-sans">
                    <p class="text-gray-500 uppercase text-xs font-bold">Total Pending</p>
                    <p class="text-3xl font-extrabold font-mono text-amber-600">{{ $stats['total_pending_appointments'] }}</p>
                </div>
            </div>

            <!-- Reception specific sections here -->
             <div class="mt-12 bg-white rounded-xl shadow-xl p-10 font-sans overflow-hidden border border-gray-100">
                <h2 class="text-2xl font-black mb-8 text-gray-800 uppercase tracking-tighter">Quick Operations</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <a href="{{ route('patient.create') }}" class="group relative p-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl text-center transition-all hover:scale-105 active:scale-95 shadow-lg shadow-blue-200">
                        <span class="block text-4xl mb-3">📝</span>
                        <span class="block text-white font-bold text-lg uppercase tracking-tight">Register Patient</span>
                    </a>
                    <a href="{{ route('patient.index') }}" class="group relative p-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl text-center transition-all hover:scale-105 active:scale-95 shadow-lg shadow-emerald-200">
                         <span class="block text-4xl mb-3">📅</span>
                         <span class="block text-white font-bold text-lg uppercase tracking-tight">Manage Appointments</span>
                    </a>
                    <a href="#" class="group relative p-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl text-center transition-all hover:scale-105 active:scale-95 shadow-lg shadow-amber-200">
                        <span class="block text-4xl mb-3">🏥</span>
                        <span class="block text-white font-bold text-lg uppercase tracking-tight">Available Rooms</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>