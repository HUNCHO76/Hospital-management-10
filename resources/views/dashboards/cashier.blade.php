<x-app-layout>
    <div class="w-full px-4 md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto py-8">
            <h1 class="text-3xl font-black font-sans text-gray-900 mb-8 uppercase tracking-tighter">Billing Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-indigo-600 p-8 rounded-[2rem] shadow-2xl shadow-indigo-200">
                    <p class="text-indigo-200 uppercase text-xs font-black tracking-widest mb-2">Revenue Today</p>
                    <p class="text-4xl font-black text-white font-mono tracking-tighter">${{ number_format($stats['total_revenue_today'], 2) }}</p>
                </div>
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100">
                    <p class="text-gray-400 uppercase text-xs font-black tracking-widest mb-2">Unpaid Invoices</p>
                    <p class="text-4xl font-black text-red-600 font-mono tracking-tighter">{{ $stats['pending_payments'] }}</p>
                </div>
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100">
                    <p class="text-gray-400 uppercase text-xs font-black tracking-widest mb-2">Total Invoices</p>
                    <p class="text-4xl font-black text-gray-900 font-mono tracking-tighter">{{ $stats['total_invoices'] }}</p>
                </div>
            </div>

            <!-- Cashier specific sections -->
             <div class="mt-16 bg-white rounded-[3rem] p-12 border border-gray-50 flex flex-col gap-10 shadow-3xl">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-1 bg-indigo-600 rounded-full"></div>
                    <h2 class="text-3xl font-black text-gray-800 uppercase italic tracking-tighter">Finance Terminal</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    <a href="#" class="group flex flex-col items-center gap-6 p-10 bg-gray-50 rounded-[2.5rem] transition-all hover:bg-indigo-600 hover:scale-105 active:scale-95 shadow-sm">
                        <span class="text-6xl group-hover:scale-110 transition grayscale group-hover:grayscale-0">🧾</span>
                        <div class="text-center">
                            <span class="block font-black text-indigo-900 group-hover:text-white uppercase text-lg tracking-tight mb-1">Make Invoice</span>
                            <span class="block text-indigo-400 group-hover:text-indigo-200 text-xs font-bold uppercase tracking-widest">New Billing</span>
                        </div>
                    </a>
                    <a href="#" class="group flex flex-col items-center gap-6 p-10 bg-gray-50 rounded-[2.5rem] transition-all hover:bg-emerald-600 hover:scale-105 active:scale-95 shadow-sm">
                        <span class="text-6xl group-hover:scale-110 transition grayscale group-hover:grayscale-0">💰</span>
                        <div class="text-center">
                            <span class="block font-black text-emerald-900 group-hover:text-white uppercase text-lg tracking-tight mb-1">Collect Payment</span>
                            <span class="block text-emerald-400 group-hover:text-emerald-200 text-xs font-bold uppercase tracking-widest">Receipting</span>
                        </div>
                    </a>
                    <a href="#" class="group flex flex-col items-center gap-6 p-10 bg-gray-50 rounded-[2.5rem] transition-all hover:bg-amber-600 hover:scale-105 active:scale-95 shadow-sm">
                        <span class="text-6xl group-hover:scale-110 transition grayscale group-hover:grayscale-0">📊</span>
                        <div class="text-center">
                            <span class="block font-black text-amber-900 group-hover:text-white uppercase text-lg tracking-tight mb-1">Revenue Report</span>
                            <span class="block text-amber-400 group-hover:text-amber-200 text-xs font-bold uppercase tracking-widest">Daily Summary</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>