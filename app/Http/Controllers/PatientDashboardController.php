<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();
        
        $stats = [
            'upcoming_appointments' => $patient ? Appointment::where('patient_id', $patient->id)->where('appointment_date', '>=', today())->count() : 0,
            'medical_records' => $patient ? $patient->medicalRecords->count() : 0,
            'outstanding_balance' => $patient ? Bill::where('patient_id', $patient->id)->where('status', 'unpaid')->sum('total_amount') : 0.00,
        ];
        return view('dashboards.patient', compact('stats'));
    }
}
