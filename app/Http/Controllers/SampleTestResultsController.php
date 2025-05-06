<?php

namespace App\Http\Controllers;

use App\Models\checkup;
use Illuminate\Http\Request;
use App\Models\sample_test_results;

class SampleTestResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = checkup::orderBy('created_at', 'desc')
            ->get()
            ->unique('patient_id');
        return view('LabCheckUp.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $patients = checkup::findOrFail($id);
        
        $diseases = checkup::find($id)->get(); // Retrieve all diseases
        return view('LabCheckUp.create', compact('patients', 'diseases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        foreach($request->diseases as $index =>$disease){

            $request->validate([
                'results' => 'required|array',
                'result.*.patient_id' => 'required|exists:patients,id',
                'result.*.checkup_id' => 'nullable|exists:checkups,id',
                'diseases' => 'required|array',
                'diseases.*.name' => 'required|string',
                'results.*.status' => 'required|string',
                'results.*.percentage' => 'required|numeric|min:0|max:100',
                'results.*.remarks' => 'nullable|string',
            ]);
        }
       dd($request->all());
    
        // Loop through the diseases and results and save each one
        foreach ($request->diseases as $index => $disease) {
            \App\Models\SampleTestResult::create([
                'patient_id' => $request->patient_id,
                'checkup_id' => $request->checkup_id,
                'disease' => $disease['name'],
                'status' => $request->results[$index]['status'],
                'percentage' => $request->results[$index]['percentage'],
                'remarks' => $request->results[$index]['remarks'] ?? null,
            ]);
        }
    
        // Redirect back with a success message
        return redirect()->route('lab.index')->with('success', 'Test results saved successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $checkups = checkup::where('patient_id', $id)->get();

        // dd($checkups);
        return view('LabCheckUp.show', compact('checkups' ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sample_test_results $sample_test_results)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sample_test_results $sample_test_results)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sample_test_results $sample_test_results)
    {
        //
    }
}
