<x-app-layout>
    <div class="w-full px-4 md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto py-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                    <p class="text-gray-500 uppercase text-xs font-bold">Total Users</p>
                    <p class="text-2xl font-bold">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                    <p class="text-gray-500 uppercase text-xs font-bold">Total Patients</p>
                    <p class="text-2xl font-bold">{{ $stats['patients'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                    <p class="text-gray-500 uppercase text-xs font-bold">Total Appointments</p>
                    <p class="text-2xl font-bold">{{ $stats['appointments'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                    <p class="text-gray-500 uppercase text-xs font-bold">Total Doctors</p>
                    <p class="text-2xl font-bold">{{ $stats['doctors'] }}</p>
                </div>
            </div>

            <!-- More admin specific sections here -->
            <div class="mt-12">
                <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('admin.user.create') }}" class="p-4 bg-gray-100 hover:bg-gray-200 rounded text-center font-medium">Add New User</a>
                    <a href="{{ route('admin.index.index') }}" class="p-4 bg-gray-100 hover:bg-gray-200 rounded text-center font-medium">Manage Permissions</a>
                    <a href="#" class="p-4 bg-gray-100 hover:bg-gray-200 rounded text-center font-medium">System Logs</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>