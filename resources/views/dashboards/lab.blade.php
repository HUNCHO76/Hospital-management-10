<x-app-layout>
    <div class="w-full px-4 md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto py-8">
            <h1 class="text-3xl font-black font-sans text-gray-900 mb-8 uppercase tracking-tighter">Laboratory Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-900 p-8 rounded-3xl shadow-xl border border-gray-800">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="p-3 bg-red-500/10 text-red-500 rounded-2xl">⚡</div>
                        <p class="text-gray-400 uppercase text-xs font-black tracking-widest">Pending Analyses</p>
                    </div>
                    <p class="text-5xl font-black text-white font-mono">{{ $stats['pending_tests'] }}</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-2xl">🧪</div>
                        <p class="text-gray-500 uppercase text-xs font-black tracking-widest">Tests Completed</p>
                    </div>
                    <p class="text-5xl font-black text-gray-900 font-mono">{{ $stats['completed_tests'] }}</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 font-sans">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="p-3 bg-indigo-500/10 text-indigo-500 rounded-2xl">👥</div>
                        <p class="text-gray-500 uppercase text-xs font-black tracking-widest">Laboratory Patients</p>
                    </div>
                    <p class="text-5xl font-black text-gray-900 font-mono">{{ $stats['total_lab_patients'] }}</p>
                </div>
            </div>

            <!-- Lab specific sections -->
             <div class="mt-16 relative overflow-hidden bg-gradient-to-tr from-gray-900 to-indigo-950 rounded-[3rem] p-12 text-white">
                <div class="relative z-10">
                    <h2 class="text-3xl font-black mb-10 uppercase tracking-tighter italic">Diagnostic Operations</h2>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        <a href="{{ route('lab.index') }}" class="p-8 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl transition-all hover:bg-white/10 hover:scale-105 active:scale-95 group">
                           <span class="block text-4xl mb-3 grayscale group-hover:grayscale-0 transition">🩸</span>
                           <span class="block font-black text-sm uppercase tracking-widest text-indigo-300">New Sample</span>
                        </a>
                         <a href="{{ route('lab.index') }}" class="p-8 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl transition-all hover:bg-white/10 hover:scale-105 active:scale-95 group">
                           <span class="block text-4xl mb-3 grayscale group-hover:grayscale-0 transition">📊</span>
                           <span class="block font-black text-sm uppercase tracking-widest text-indigo-300">Enter Results</span>
                        </a>
                         <a href="#" class="p-8 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl transition-all hover:bg-white/10 hover:scale-105 active:scale-95 group">
                           <span class="block text-4xl mb-3 grayscale group-hover:grayscale-0 transition">🔬</span>
                           <span class="block font-black text-sm uppercase tracking-widest text-indigo-300">Equipment</span>
                        </a>
                         <a href="#" class="p-8 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl transition-all hover:bg-white/10 hover:scale-105 active:scale-95 group">
                           <span class="block text-4xl mb-3 grayscale group-hover:grayscale-0 transition">🧪</span>
                           <span class="block font-black text-sm uppercase tracking-widest text-indigo-300">Reagents</span>
                        </a>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-red-500/20 blur-[100px] rounded-full"></div>
            </div>
        </div>
    </div>
</x-app-layout>