<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Medical Document') }} - {{ $patient->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('patient-documents.store', $patient) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Document Type -->
                        <div>
                            <label for="document_type" class="block text-sm font-medium text-gray-700">
                                Document Type <span class="text-red-500">*</span>
                            </label>
                            <select id="document_type" name="document_type" required class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 @error('document_type') border-red-500 @enderror">
                                <option value="">Select Document Type</option>
                                <option value="lab_report">Lab Report</option>
                                <option value="xray">X-Ray</option>
                                <option value="ct_scan">CT Scan</option>
                                <option value="ultrasound">Ultrasound</option>
                                <option value="prescription">Prescription</option>
                                <option value="discharge_summary">Discharge Summary</option>
                                <option value="pathology_report">Pathology Report</option>
                                <option value="other">Other</option>
                            </select>
                            @error('document_type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">
                                File <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md @error('file') border-red-500 @enderror">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-12l-3.172-3.172a4 4 0 00-5.656 0L28 20M9 20l3.172-3.172a4 4 0 015.656 0L28 20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file" name="file" type="file" required class="sr-only" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.csv">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PDF, DOC, DOCX, JPG, PNG, XLSX, CSV up to 10MB
                                    </p>
                                </div>
                            </div>
                            @error('file')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Medical Record (Optional) -->
                        @if (isset($medicalRecord))
                            <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->id }}">
                        @else
                            <div>
                                <label for="medical_record_id" class="block text-sm font-medium text-gray-700">
                                    Related Medical Record (Optional)
                                </label>
                                <select id="medical_record_id" name="medical_record_id" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
                                    <option value="">No Related Record</option>
                                    @foreach ($patient->medicalRecords as $record)
                                        <option value="{{ $record->id }}">
                                            {{ $record->diagnosis }} - {{ $record->visit_date->format('M d, Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description (Optional)
                            </label>
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 @error('description') border-red-500 @enderror" placeholder="Add any notes about this document..."></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confidential -->
                        <div class="flex items-center">
                            <input id="is_confidential" name="is_confidential" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_confidential" class="ml-2 block text-sm text-gray-700">
                                Mark as confidential (restricted access)
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between space-x-4">
                            <a href="{{ route('patient-documents.index', $patient) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Upload Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
