<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Pre_test;
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
        $pre_tests = Pre_test::with('patient')->paginate(10);
        return view('pre_tests.index', compact('pre_tests'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $patient = Patient::findOrFail($id);
        return view('pre_tests.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'blood_pressure' => 'required|string',
            'temperature' => 'required|numeric',
            'pulse_rate' => 'required|integer',
            'respiration_rate' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        $validated['nurse_id'] = Auth::id(); // Assuming nurse is authenticated user

        Pre_test::create($validated);

        return redirect()->back()->with('success', 'Pre-test recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pre_test $pre_test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pre_test $pre_test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pre_test $pre_test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pre_test $pre_test)
    {
        //
    }
}
