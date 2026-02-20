<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Pretest;
use Illuminate\Http\Request;
use App\Models\DoctorPatient;
use App\Http\Controllers\Controller;

class DoctorPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $doctorPatients = DoctorPatient::with(['doctor.user', 'patient'])->latest()->paginate(10);
        return view('DoctorPatient.index', compact('doctorPatients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $pretest = Pretest::findOrFail($id);
        $doctors = Doctor::all();
        return view('DoctorPatient.create', compact('pretest', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pretest_id' => 'required|exists:pretests,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);
        
        // Get the patient_id from the pretest
        $pretest = Pretest::findOrFail($request->pretest_id);
        
        DoctorPatient::create([
            'patient_id' => $pretest->patient_id,
            'doctor_id' => $request->doctor_id,
            'assigned_at' => now(),
        ]);

        return to_route('doctor_patient.index')->with('success', 'Doctor assigned to patient successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DoctorPatient $doctor_Patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DoctorPatient $doctor_Patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DoctorPatient $doctor_Patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DoctorPatient $doctor_Patient)
    {
        //
    }
}
