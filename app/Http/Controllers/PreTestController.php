<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Pretest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all pre-tests
        $pre_tests = Pretest::with('patient')->latest()->paginate(10);
        return view('pre_tests.index', compact('pre_tests'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        if ($id) {
            $patient = Patient::findOrFail($id);
            return view('pre_tests.create', compact('patient'));
        }
        
        // If no patient ID provided, show patient selection page
        $patients = Patient::all();
        return view('pre_tests.select_patient', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'height' => 'required|numeric|min:0|max:300',
            'weight' => 'required|numeric|min:0|max:500',
            'blood_pressure' => 'required|string|max:20',
            'temperature' => 'required|numeric|min:30|max:45',
            'pulse_rate' => 'required|integer|min:30|max:200',
            'respiration_rate' => 'required|integer|min:5|max:60',
            'notes' => 'nullable|string',
        ]);

        $validated['nurse_id'] = Auth::id(); // Assuming nurse is authenticated user

        Pretest::create($validated);

        return redirect()->back()->with('success', 'Pre-test recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pretest $pretest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pretest $pretest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pretest $pretest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pretest $pretest)
    {
        //
    }
}
