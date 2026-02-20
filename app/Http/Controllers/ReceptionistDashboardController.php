<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;

class ReceptionistDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'patients_registered_today' => Patient::whereDate('created_at', today())->count(),
            'appointments_booked_today' => Appointment::whereDate('created_at', today())->count(),
            'total_pending_appointments' => Appointment::where('status', 'pending')->count(),
        ];
        return view('dashboards.receptionist', compact('stats'));
    }
}
