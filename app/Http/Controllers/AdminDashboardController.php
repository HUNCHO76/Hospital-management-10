<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'patients' => Patient::count(),
            'appointments' => Appointment::count(),
            'doctors' => Doctor::count(),
        ];
        return view('dashboards.admin', compact('stats'));
    }
}
