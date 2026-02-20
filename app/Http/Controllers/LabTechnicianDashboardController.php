<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SampleTestResult;
use App\Models\Patient;

class LabTechnicianDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_tests' => SampleTestResult::where('status', 'pending')->count(),
            'completed_tests' => SampleTestResult::where('status', 'completed')->count(),
            'total_lab_patients' => Patient::has('sampleTestResult')->count(),
        ];
        return view('dashboards.lab', compact('stats'));
    }
}
