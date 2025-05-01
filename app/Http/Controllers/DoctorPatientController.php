<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Pre_test;
use Illuminate\Http\Request;
use App\Models\Doctor_Patient;

class DoctorPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $doctorPatients = Doctor_Patient::paginate(10);
        return view('DoctorPatient.index', compact('doctorPatients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $pretest = Pre_test::findOrFail($id);
        $doctors = Doctor::all();
        return view('DoctorPatient.create', compact('pretest', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pretest_id' => 'required|exists:pre_tests,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);
        // dd($request);
        Doctor_Patient::create([
            'pretest_id' => $request->pretest_id,
            'doctor_id' => $request->doctor_id,
        ]);

        return to_route('doctor_patient.index')->with('success', 'Doctor assigned to patient successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor_Patient $doctor_Patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor_Patient $doctor_Patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor_Patient $doctor_Patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor_Patient $doctor_Patient)
    {
        //
    }
}
