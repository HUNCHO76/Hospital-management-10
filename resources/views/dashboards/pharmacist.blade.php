<x-app-layout>
    <div class="w-full px-4 md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto py-8">
            <h1 class="text-3xl font-bold font-sans text-gray-900 mb-8">Pharmacy Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md border-b-4 border-indigo-600">
                    <p class="text-gray-500 uppercase text-xs font-bold font-sans">Total Inventory</p>
                    <p class="text-3xl font-black text-indigo-700 font-mono">{{ $stats['total_medicines'] }} Items</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-b-4 border-emerald-600">
                    <p class="text-gray-500 uppercase text-xs font-bold font-sans">Pending Prescriptions</p>
                    <p class="text-3xl font-black text-emerald-700 font-mono">{{ $stats['pending_prescriptions'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-b-4 border-rose-600 font-sans">
                    <p class="text-gray-500 uppercase text-xs font-bold">Low Stock Alerts</p>
                    <p class="text-3xl font-black text-rose-700 font-mono">{{ $stats['low_stock_medicines'] }}</p>
                </div>
            </div>

            <!-- Pharmacy specific sections -->
             <div class="mt-12 bg-white rounded-2xl shadow-2xl p-8 font-sans border-2 border-gray-50">
                <h2 class="text-2xl font-black mb-10 text-gray-800 uppercase tracking-tight flex items-center gap-3">
                    <span class="p-2 bg-indigo-500 rounded-lg shadow-lg">💊</span>
                    Pharmacy Operations
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="#" class="group p-8 bg-indigo-50 hover:bg-indigo-600 transition-all rounded-3xl shadow-lg hover:shadow-indigo-200">
                        <span class="block text-indigo-600 group-hover:text-white font-black text-xl mb-2">Inventory</span>
                        <span class="block text-indigo-400 group-hover:text-indigo-100 text-sm font-medium">Manage stock and medicines</span>
                    </a>
                    <a href="#" class="group p-8 bg-emerald-50 hover:bg-emerald-600 transition-all rounded-3xl shadow-lg hover:shadow-emerald-200">
                        <span class="block text-emerald-600 group-hover:text-white font-black text-xl mb-2">Dispense</span>
                        <span class="block text-emerald-400 group-hover:text-emerald-100 text-sm font-medium">Verify and fulfill orders</span>
                    </a>
                    <a href="#" class="group p-8 bg-rose-50 hover:bg-rose-600 transition-all rounded-3xl shadow-lg hover:shadow-rose-200">
                        <span class="block text-rose-600 group-hover:text-white font-black text-xl mb-2">Supplier</span>
                        <span class="block text-rose-400 group-hover:text-rose-100 text-sm font-medium">Order medicine refills</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>