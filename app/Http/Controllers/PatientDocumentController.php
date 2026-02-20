<?php

namespace App\Http\Controllers;

use App\Models\PatientDocument;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientDocumentController extends Controller
{
    /**
     * Display all documents for a patient
     */
    public function indexByPatient(Patient $patient)
    {
        $documents = $patient->documents()
                            ->orderBy('upload_date', 'desc')
                            ->paginate(20);

        return view('patient-documents.index', compact('patient', 'documents'));
    }

    /**
     * Display documents for a specific medical record
     */
    public function indexByMedicalRecord(MedicalRecord $medicalRecord)
    {
        $documents = $medicalRecord->documents()
                                  ->orderBy('upload_date', 'desc')
                                  ->get();

        $patient = $medicalRecord->patient;

        return view('patient-documents.medical-record', compact('medicalRecord', 'documents', 'patient'));
    }

    /**
     * Show the form for uploading a new document
     */
    public function create(Patient $patient, MedicalRecord $medicalRecord = null)
    {
        return view('patient-documents.create', compact('patient', 'medicalRecord'));
    }

    /**
     * Store the uploaded document
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'document_type' => 'required|in:lab_report,xray,ct_scan,ultrasound,prescription,discharge_summary,pathology_report,other',
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,xlsx,csv',
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'description' => 'nullable|string|max:500',
            'is_confidential' => 'nullable|boolean',
        ]);

        try {
            // Store the file
            $file = $request->file('file');
            $path = $file->store("patient-documents/{$patient->id}", 'private');

            // Create document record
            PatientDocument::create([
                'patient_id' => $patient->id,
                'medical_record_id' => $validated['medical_record_id'] ?? null,
                'document_type' => $validated['document_type'],
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'uploaded_by' => auth()->id(),
                'description' => $validated['description'] ?? null,
                'is_confidential' => $validated['is_confidential'] ?? false,
            ]);

            return redirect()->route('patient-documents.index', $patient)
                           ->with('success', 'Document uploaded successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to upload document: ' . $e->getMessage()]);
        }
    }

    /**
     * Show document details
     */
    public function show(PatientDocument $document)
    {
        // Check authorization
        if (auth()->user()->cannot('view', $document)) {
            abort(403, 'Unauthorized');
        }

        return view('patient-documents.show', compact('document'));
    }

    /**
     * Download a document
     */
    public function download(PatientDocument $document)
    {
        // Check authorization
        if (auth()->user()->cannot('view', $document)) {
            abort(403, 'Unauthorized');
        }

        return Storage::disk('private')->download(
            $document->file_path,
            $document->file_name
        );
    }

    /**
     * Preview a document (for PDFs and images)
     */
    public function preview(PatientDocument $document)
    {
        // Check authorization
        if (auth()->user()->cannot('view', $document)) {
            abort(403, 'Unauthorized');
        }

        if (!in_array($document->mime_type, ['application/pdf', 'image/jpeg', 'image/png'])) {
            return redirect()->route('patient-documents.download', $document);
        }

        return response()->file(
            Storage::disk('private')->path($document->file_path)
        );
    }

    /**
     * Edit document details
     */
    public function edit(PatientDocument $document)
    {
        return view('patient-documents.edit', compact('document'));
    }

    /**
     * Update document details
     */
    public function update(Request $request, PatientDocument $document)
    {
        $validated = $request->validate([
            'document_type' => 'required|in:lab_report,xray,ct_scan,ultrasound,prescription,discharge_summary,pathology_report,other',
            'description' => 'nullable|string|max:500',
            'is_confidential' => 'nullable|boolean',
        ]);

        try {
            $document->update($validated);

            return redirect()->route('patient-documents.show', $document)
                           ->with('success', 'Document updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update document: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete a document
     */
    public function destroy(PatientDocument $document)
    {
        try {
            // Delete the physical file
            Storage::disk('private')->delete($document->file_path);

            // Delete the database record
            $patient = $document->patient;
            $document->delete();

            return redirect()->route('patient-documents.index', $patient)
                           ->with('success', 'Document deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete document: ' . $e->getMessage()]);
        }
    }

    /**
     * Get documents summary for a patient
     */
    public function getSummary(Patient $patient)
    {
        $summary = [
            'total' => $patient->documents()->count(),
            'by_type' => $patient->documents()
                                ->groupBy('document_type')
                                ->selectRaw('document_type, COUNT(*) as count')
                                ->pluck('count', 'document_type'),
            'latest' => $patient->documents()
                              ->latest('upload_date')
                              ->first(),
        ];

        return response()->json($summary);
    }
}
