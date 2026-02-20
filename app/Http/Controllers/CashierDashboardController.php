<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;

class CashierDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_invoices' => Bill::count(),
            'pending_payments' => Bill::where('status', 'unpaid')->count(),
            'total_revenue_today' => Bill::whereDate('created_at', today())->where('status', 'paid')->sum('amount'),
        ];
        return view('dashboards.cashier', compact('stats'));
    }
}
