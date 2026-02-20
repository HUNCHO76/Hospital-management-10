<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Prescription;

class PharmacistDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_medicines' => Medicine::count(),
            'pending_prescriptions' => Prescription::where('status', 'pending')->count(),
            'low_stock_medicines' => Medicine::where('Quantity', '<', 10)->count(),
        ];
        return view('dashboards.pharmacist', compact('stats'));
    }
}
