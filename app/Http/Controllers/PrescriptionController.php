<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of prescriptions
     */
    public function index()
    {
        $query = Prescription::with(['medicalRecord.patient', 'medicalRecord.doctor.user']);

        // If user is a doctor, show only their prescriptions
        if (auth()->user()->Role === 'doctor') {
            $doctor = Doctor::where('user_id', auth()->id())->first();
            if ($doctor) {
                $query->whereHas('medicalRecord', function($q) use ($doctor) {
                    $q->where('doctor_id', $doctor->id);
                });
            }
        }

        $prescriptions = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new prescription
     */
    public function create()
    {
        $medicalRecords = MedicalRecord::with(['patient', 'doctor'])->get();
        
        // If user is a doctor, show only their medical records
        if (auth()->user()->Role === 'doctor') {
            $doctor = Doctor::where('user_id', auth()->id())->first();
            if ($doctor) {
                $medicalRecords = MedicalRecord::with(['patient', 'doctor'])
                    ->where('doctor_id', $doctor->id)
                    ->get();
            }
        }

        return view('prescriptions.create', compact('medicalRecords'));
    }

    /**
     * Store a newly created prescription
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medication' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'instructions' => 'nullable|string',
        ]);

        try {
            Prescription::create($validated);

            return redirect()->route('prescription.index')
                           ->with('success', 'Prescription created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create prescription: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    /**
     * Display the specified prescription
     */
    public function show($id)
    {
        $prescription = Prescription::with(['medicalRecord.patient', 'medicalRecord.doctor.user'])
            ->findOrFail($id);

        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the prescription
     */
    public function edit($id)
    {
        $prescription = Prescription::findOrFail($id);
        $medicalRecords = MedicalRecord::with(['patient', 'doctor'])->get();
        
        // If user is a doctor, show only their medical records
        if (auth()->user()->Role === 'doctor') {
            $doctor = Doctor::where('user_id', auth()->id())->first();
            if ($doctor) {
                $medicalRecords = MedicalRecord::with(['patient', 'doctor'])
                    ->where('doctor_id', $doctor->id)
                    ->get();
            }
        }

        return view('prescriptions.edit', compact('prescription', 'medicalRecords'));
    }

    /**
     * Update the specified prescription
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medication' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'instructions' => 'nullable|string',
        ]);

        try {
            $prescription = Prescription::findOrFail($id);
            $prescription->update($validated);

            return redirect()->route('prescription.index')
                           ->with('success', 'Prescription updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update prescription: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    /**
     * Remove the specified prescription
     */
    public function destroy($id)
    {
        try {
            $prescription = Prescription::findOrFail($id);
            $prescription->delete();

            return redirect()->route('prescription.index')
                           ->with('success', 'Prescription deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete prescription: ' . $e->getMessage()]);
        }
    }
}
