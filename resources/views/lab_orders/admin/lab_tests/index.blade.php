<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lab Test Catalog</h2>
            <a href="{{ route('admin.lab-tests.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-xs font-semibold uppercase">Add Test</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Test</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ref Range</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($labTests as $test)
                            <tr>
                                <td class="px-6 py-4 text-sm font-semibold">{{ $test->test_name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $test->category ?: 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $test->reference_range ?: 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $test->unit ?: 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $test->price ? number_format($test->price, 2) : 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $test->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.lab-tests.edit', $test) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('admin.lab-tests.destroy', $test) }}" method="POST" class="inline-block ml-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this test?')" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-6 text-center text-gray-500 text-sm">No lab tests found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $labTests->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
