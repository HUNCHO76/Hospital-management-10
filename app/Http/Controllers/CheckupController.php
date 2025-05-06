<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\checkup;
use App\Models\Disease;
use App\Models\Patient;
use App\Models\Pretest;
use App\Models\Pre_test;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve data with patient info and pretest results
        $checkups = checkup::paginate(10);
        return view('Checkup.index', compact('checkups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $pretests = Pretest::findOrFail($id);
        $authId = auth()->id();
        $doctors = Doctor::where('user_id', '=', 11)->get();
        $diseases = Disease::get();
        // dd($doctors);
        return view('Checkup.create', compact('pretests', 'doctors', 'diseases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'pretest_id' => 'required|exists:pretests,id',
            'doctor_id' => 'required|exists:doctors,id',
            'diseases' => 'required|array',
            'diseases.*.name' => 'required|string',
            // 'status' => 'nullable|string',
        ]);

        // Loop through the diseases and save each one
        foreach ($request->diseases as $disease) {
            Checkup::create([
                'pretest_id' => $request->pretest_id,
                'doctor_id' => $request->doctor_id,
                'disease' => $disease['name'],
                // 'notes' => $request->notes,
            ]);
        }

        // Redirect back with a success message
        return redirect()->route('checkup.index')->with('success', 'Checkup data saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(checkup $checkup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(checkup $checkup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, checkup $checkup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(checkup $checkup)
    {
        //
    }
}
