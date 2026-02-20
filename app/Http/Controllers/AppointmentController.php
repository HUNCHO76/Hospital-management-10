<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor']);

        // If user is a doctor, show only their appointments
        if (auth()->user()->Role === 'doctor') {
            $doctor = Doctor::where('user_id', auth()->id())->first();
            if ($doctor) {
                $query->where('doctor_id', $doctor->id);
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by doctor
        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Filter by patient
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('appointment_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('appointment_date', '<=', $request->to_date);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(6);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment
     */
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created appointment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            'end_time' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'],
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if (strlen($validated['end_time']) === 5) {
            $validated['end_time'] .= ':00';
        }

        try {
            $appointment = Appointment::create($validated);

            return redirect()->route('appointment.index')
                           ->with('success', 'Appointment created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create appointment: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified appointment
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'bill']);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the appointment
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified appointment
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'end_time' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'],
            'status' => 'required|in:scheduled,completed,cancelled',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if (strlen($validated['end_time']) === 5) {
            $validated['end_time'] .= ':00';
        }

        try {
            $appointment->update($validated);

            return redirect()->route('appointment.show', $appointment)
                           ->with('success', 'Appointment updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update appointment: ' . $e->getMessage()]);
        }
    }

    /**
     * Cancel an appointment
     */
    public function cancel(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        try {
            $appointment->update([
                'status' => 'cancelled',
                'cancellation_reason' => $validated['cancellation_reason'],
                'cancelled_at' => now(),
            ]);

            return redirect()->back()
                           ->with('success', 'Appointment cancelled successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to cancel appointment: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the specified appointment
     */
    public function destroy(Appointment $appointment)
    {
        try {
            $appointment->forceDelete();

            return redirect()->route('appointment.index')
                           ->with('success', 'Appointment deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete appointment: ' . $e->getMessage()]);
        }
    }

    /**
     * Get upcoming appointments for dashboard
     */
    public function getUpcomingAppointments($limit = 10)
    {
        return Appointment::upcoming()
                         ->take($limit)
                         ->get();
    }

    /**
     * Send appointment reminders
     */
    public function sendReminders()
    {
        $appointments = Appointment::where('appointment_date', '<=', now()->addHours(24))
                                   ->where('appointment_date', '>', now())
                                   ->where('reminder_sent', false)
                                   ->where('status', 'scheduled')
                                   ->get();

        foreach ($appointments as $appointment) {
            // Send reminder notification
            // TODO: Implement notification system
            $appointment->update(['reminder_sent' => true]);
        }

        return response()->json(['sent' => count($appointments)]);
    }
}

