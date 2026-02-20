<x-app-layout>
    <div class="w-full px-4 md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto py-8">
            <h1 class="text-3xl font-bold font-sans text-gray-900 mb-8">Nurse Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md border-r-4 border-cyan-500">
                    <p class="text-gray-500 uppercase text-xs font-bold font-sans">Pre-tests Today</p>
                    <p class="text-3xl font-black text-cyan-600 font-mono">{{ $stats['pretests_today'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-r-4 border-pink-500">
                    <p class="text-gray-500 uppercase text-xs font-bold font-sans">Active Admissions</p>
                    <p class="text-3xl font-black text-pink-600 font-mono">{{ $stats['active_admissions'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-r-4 border-indigo-500 font-sans">
                    <p class="text-gray-500 uppercase text-xs font-bold">Total Patients</p>
                    <p class="text-3xl font-black text-indigo-600 font-mono">{{ $stats['patients_to_monitor'] }}</p>
                </div>
            </div>

            <!-- Nurse specific sections -->
             <div class="mt-12 bg-white rounded-3xl shadow-xl p-8 border border-gray-100 flex flex-col gap-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Nursing Care Tasks</h2>
                    <span class="px-4 py-1 bg-pink-100 text-pink-600 rounded-full text-xs font-bold uppercase">Active Duty</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="{{ route('pre_tests.index') }}" class="group p-6 bg-cyan-50 border border-cyan-100 rounded-2xl flex flex-col items-center gap-3 transition hover:bg-cyan-500 hover:border-cyan-500 hover:scale-105">
                        <span class="text-3xl group-hover:scale-125 transition">🌡️</span>
                        <span class="font-bold text-cyan-700 group-hover:text-white uppercase text-sm">Vitals & Pretests</span>
                    </a>
                    <a href="{{ route('patient.index') }}" class="group p-6 bg-pink-50 border border-pink-100 rounded-2xl flex flex-col items-center gap-3 transition hover:bg-pink-500 hover:border-pink-500 hover:scale-105">
                        <span class="text-3xl group-hover:scale-125 transition">🛌</span>
                        <span class="font-bold text-pink-700 group-hover:text-white uppercase text-sm">Ward rounds</span>
                    </a>
                    <a href="{{ route('doctor_patient.index') }}" class="group p-6 bg-indigo-50 border border-indigo-100 rounded-2xl flex flex-col items-center gap-3 transition hover:bg-indigo-500 hover:border-indigo-500 hover:scale-105">
                        <span class="text-3xl group-hover:scale-125 transition">🏥</span>
                        <span class="font-bold text-indigo-700 group-hover:text-white uppercase text-sm">Patient monitoring</span>
                    </a>
                    <a href="#" class="group p-6 bg-gray-50 border border-gray-100 rounded-2xl flex flex-col items-center gap-3 transition hover:bg-gray-800 hover:border-gray-800 hover:scale-105">
                        <span class="text-3xl group-hover:scale-125 transition">📋</span>
                        <span class="font-bold text-gray-600 group-hover:text-white uppercase text-sm">Shift Report</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>