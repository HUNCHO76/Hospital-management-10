<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Disease;
use App\Models\Pretest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve data with patient info and pretest results
        $checkups = \App\Models\checkup::paginate(10);
        return view('checkup.index', compact('checkups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        if (!$id) {
            return redirect()->route('assigned_patients')
                ->with('error', 'Please select a patient from the list to create a checkup.');
        }
        
        $pretests = Pretest::with('patient')->findOrFail($id);
        $doctor = Doctor::with('user')->where('user_id', auth()->id())->first();

        if (!$doctor) {
            return redirect()->route('checkup.index')
                ->with('error', 'Doctor profile not found. Please contact admin.');
        }
        $diseases = Disease::get();
        return view('checkup.create', compact('pretests', 'doctor', 'diseases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if (!$doctor) {
            return redirect()->route('checkup.index')
                ->with('error', 'Doctor profile not found. Please contact admin.');
        }

        $validated = $request->validate([
            'pretest_id' => 'required|exists:pretests,id',
            'status' => 'required|in:completed,inprogress,pending',
            'primary_disease' => 'required|string|max:255',
            'diseases' => 'required|array',
            'diseases.*.name' => 'required|string|max:255|distinct',
            'diseases.*.availability_percentage' => 'required|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($validated, $doctor) {
            $checkup = \App\Models\checkup::create([
                'pretest_id' => $validated['pretest_id'],
                'doctor_id' => $doctor->id,
                'disease' => $validated['primary_disease'],
                'status' => $validated['status'],
            ]);

            foreach ($validated['diseases'] as $disease) {
                \App\Models\checkup_diseases::create([
                    'checkup_id' => $checkup->id,
                    'disease_name' => $disease['name'],
                    'availability_percentage' => $disease['availability_percentage'],
                ]);
            }
        });

        return redirect()->route('checkup.index')->with('success', 'Checkup data saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id = null)
    {
        if (!$id) {
            return redirect()->route('checkup.index')
                ->with('error', 'No checkup selected.');
        }

        $checkup = \App\Models\checkup::with(['pretest.patient', 'doctor.user', 'differentialDiagnoses'])->findOrFail($id);

        return view('checkup.show', compact('checkup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id = null)
    {
        if (!$id) {
            return redirect()->route('checkup.index')
                ->with('error', 'No checkup selected.');
        }

        $checkup = \App\Models\checkup::with(['pretest.patient', 'doctor.user'])->findOrFail($id);
        $diseases = Disease::all();

        return view('checkup.edit', compact('checkup', 'diseases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id = null)
    {
        if (!$id) {
            return redirect()->route('checkup.index')
                ->with('error', 'No checkup selected.');
        }

        $validated = $request->validate([
            'disease' => 'required|string|max:255',
            'status' => 'required|in:completed,inprogress,pending',
        ]);

        $checkup = \App\Models\checkup::findOrFail($id);
        $checkup->update($validated);

        return redirect()->route('checkup.show', $checkup->id)
            ->with('success', 'Checkup updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id = null)
    {
        if (!$id) {
            return redirect()->route('checkup.index')
                ->with('error', 'No checkup selected.');
        }

        $checkup = \App\Models\checkup::findOrFail($id);
        $checkup->delete();

        return redirect()->route('checkup.index')
            ->with('success', 'Checkup deleted successfully!');
    }
}
