<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CashierReportController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $payments = Payment::with('invoice.patient')
            ->whereDate('payment_date', $date)
            ->latest('payment_date')
            ->get();

        $collectionsByMethod = $payments
            ->groupBy('payment_method')
            ->map(fn($rows) => round((float) $rows->sum('amount'), 2));

        $invoices = Invoice::with('patient')
            ->whereDate('invoice_date', $date)
            ->latest('invoice_date')
            ->get();

        $totalCollections = round((float) $payments->sum('amount'), 2);

        return view('billing.cashier.reports.daily', compact('date', 'payments', 'collectionsByMethod', 'invoices', 'totalCollections'));
    }

    public function monthly(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        [$year, $monthNumber] = explode('-', $month);

        $payments = Payment::with('invoice.patient')
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $monthNumber)
            ->latest('payment_date')
            ->get();

        $collectionsByMethod = $payments
            ->groupBy('payment_method')
            ->map(fn($rows) => round((float) $rows->sum('amount'), 2));

        $invoices = Invoice::with('patient')
            ->whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $monthNumber)
            ->latest('invoice_date')
            ->get();

        $totalCollections = round((float) $payments->sum('amount'), 2);

        return view('billing.cashier.reports.monthly', compact('month', 'payments', 'collectionsByMethod', 'invoices', 'totalCollections'));
    }
}
