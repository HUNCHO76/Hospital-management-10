<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user();
        $stats = [
            'appointments_today' => Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', today())->count(),
            'total_patients' => Patient::whereHas('appointment', function($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            })->distinct()->count(),
            'pending_appointments' => Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count(),
        ];
        return view('dashboards.doctor', compact('stats'));
    }
}
