<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display a listing of admissions.
     */
    public function index()
    {
        $admissions = Admission::with(['patient', 'room'])
            ->latest()
            ->paginate(15);
        
        return view('admissions.index', compact('admissions'));
    }

    /**
     * Show the form for creating a new admission.
     */
    public function create()
    {
        $patients = Patient::all();
        $rooms = Room::where('status', 'available')->get();
        
        return view('admissions.create', compact('patients', 'rooms'));
    }

    /**
     * Store a newly created admission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:rooms,id',
            'admission_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Admission::create([
            'patient_id' => $request->patient_id,
            'room_id' => $request->room_id,
            'admission_date' => $request->admission_date,
            'notes' => $request->notes,
        ]);

        // Update room status to occupied
        Room::where('id', $request->room_id)->update(['status' => 'occupied']);

        return redirect()->route('admission.index')
            ->with('success', 'Patient admitted successfully.');
    }

    /**
     * Display the specified admission.
     */
    public function show($id)
    {
        $admission = Admission::with(['patient', 'room'])->findOrFail($id);
        
        return view('admissions.show', compact('admission'));
    }

    /**
     * Show the form for editing the specified admission.
     */
    public function edit($id)
    {
        $admission = Admission::findOrFail($id);
        $patients = Patient::all();
        $rooms = Room::all();
        
        return view('admissions.edit', compact('admission', 'patients', 'rooms'));
    }

    /**
     * Update the specified admission.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:rooms,id',
            'admission_date' => 'required|date',
            'discharge_date' => 'nullable|date|after_or_equal:admission_date',
            'notes' => 'nullable|string',
        ]);

        $admission = Admission::findOrFail($id);
        $oldRoomId = $admission->room_id;

        $admission->update([
            'patient_id' => $request->patient_id,
            'room_id' => $request->room_id,
            'admission_date' => $request->admission_date,
            'discharge_date' => $request->discharge_date,
            'notes' => $request->notes,
        ]);

        // Update room statuses if room changed
        if ($oldRoomId != $request->room_id) {
            Room::where('id', $oldRoomId)->update(['status' => 'available']);
            Room::where('id', $request->room_id)->update(['status' => 'occupied']);
        }

        // If discharged, make room available
        if ($request->discharge_date) {
            Room::where('id', $request->room_id)->update(['status' => 'available']);
        }

        return redirect()->route('admission.index')
            ->with('success', 'Admission updated successfully.');
    }

    /**
     * Remove the specified admission.
     */
    public function destroy($id)
    {
        $admission = Admission::findOrFail($id);
        
        // Make room available again
        Room::where('id', $admission->room_id)->update(['status' => 'available']);
        
        $admission->delete();

        return redirect()->route('admission.index')
            ->with('success', 'Admission deleted successfully.');
    }
}
