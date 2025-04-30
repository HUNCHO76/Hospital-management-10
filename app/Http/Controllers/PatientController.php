<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Fetch 10 records per page
        return view('Patient.create');
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
        // Validate incoming request data
        $request->validate([
            'registration_no' => 'nullable|string|max:255',
            'FullName' => 'required|string|max:255',
            // 'Date_of_birth' => 'nullable|date',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'home_phone' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255',
        ]);

        // Insert data into the patients table
        $patient = new Patient();
        $patient->registration_no = $request->registration_no;
        $patient->FullName = $request->FullName;
        $patient->user_id = auth()->id();
        // $patient->Date_of_birth = $request->Date_of_birth;
        $patient->age = $request->age;
        $patient->gender = $request->gender;
        $patient->marital_status = $request->marital_status;
        $patient->phone = $request->phone;
        $patient->occupation = $request->occupation;
        $patient->country = $request->country;
        $patient->home_phone = $request->home_phone;
        $patient->payment_method = $request->payment_method;

        $patient->save();

        // Redirect or respond with success
        return redirect()->route('patient.index')->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $patients = Patient::paginate(10);
        return view('Patient.index', compact('patients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
