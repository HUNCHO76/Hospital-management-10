<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\DoctorPatient;
use App\Models\Doctor_Patient;
use App\Models\Doctor;

class AssignedPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the currently logged-in doctor
        $doctor = Doctor::where('user_id', auth()->id())->first();
        
        if (!$doctor) {
            abort(403, 'Unauthorized - No doctor profile found');
        }
        
        // Retrieve data with patient info and pretest results for this doctor only
        $assignedPatients = DoctorPatient::with([
            'pretest.patient', // includes patient info
        ])->where('doctor_id', $doctor->id)
          ->paginate(10);
            // dd($assignedPatients);
        return view('AssignedPatient.index', compact('assignedPatients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
