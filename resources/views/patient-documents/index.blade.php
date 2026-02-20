<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Medical Documents - {{ $patient->full_name }}
            </h2>
            <a href="{{ route('patient-documents.create', $patient) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Upload Document
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Document Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Total Documents</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $documents->total() }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Lab Reports</div>
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $documents->pluck('document_type')->countBy()->get('lab_report', 0) }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">X-Rays</div>
                    <div class="text-3xl font-bold text-purple-600">
                        {{ $documents->pluck('document_type')->countBy()->get('xray', 0) }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Prescriptions</div>
                    <div class="text-3xl font-bold text-green-600">
                        {{ $documents->pluck('document_type')->countBy()->get('prescription', 0) }}
                    </div>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                @if ($documents->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Size</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($documents as $document)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $document->document_type_badge }}">
                                                {{ ucwords(str_replace('_', ' ', $document->document_type)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $document->file_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $document->readable_file_size }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $document->upload_date->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $document->uploadedBy->FirstName }} {{ $document->uploadedBy->LastName }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('patient-documents.preview', $document) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">Preview</a>
                                            <a href="{{ route('patient-documents.download', $document) }}" class="ml-2 text-blue-600 hover:text-blue-900">Download</a>
                                            <a href="{{ route('patient-documents.edit', $document) }}" class="ml-2 text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <form action="{{ route('patient-documents.destroy', $document) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ml-2 text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        {{ $documents->links() }}
                    </div>
                @else
                    <div class="px-6 py-4 text-center text-gray-500">
                        No documents uploaded yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
