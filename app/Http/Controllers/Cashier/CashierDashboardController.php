<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class CashierDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $todayCollections = Payment::whereDate('payment_date', $today)->sum('amount');
        $pendingInvoicesCount = Invoice::whereIn('status', ['pending', 'partially_paid'])->count();

        $queuePatients = Appointment::with('patient')
            ->whereDate('appointment_date', $today)
            ->whereIn('status', ['scheduled', 'completed'])
            ->latest('appointment_date')
            ->take(10)
            ->get();

        return view('billing.cashier.dashboard', compact('todayCollections', 'pendingInvoicesCount', 'queuePatients'));
    }
}
