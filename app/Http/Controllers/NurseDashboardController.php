<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pretest;
use App\Models\Admission;
use App\Models\Patient;

class NurseDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pretests_today' => Pretest::whereDate('created_at', today())->count(),
            'active_admissions' => Admission::whereNull('discharge_date')->count(),
            'patients_to_monitor' => Patient::count(),
        ];
        return view('dashboards.nurse', compact('stats'));
    }
}
