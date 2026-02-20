<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Http\Controllers\Controller;
use App\Models\InsuranceClaim;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class BillingReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());

        $invoices = Invoice::with(['patient', 'cashier'])
            ->whereBetween('invoice_date', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->latest('invoice_date')
            ->paginate(20);

        $payments = Payment::whereBetween('payment_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
        $totalInvoiced = Invoice::whereBetween('invoice_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->sum('total_amount');

        $summary = [
            'total_invoiced' => round((float) $totalInvoiced, 2),
            'total_collected' => round((float) $payments->sum('amount'), 2),
            'collections_by_method' => $payments->groupBy('payment_method')->map(fn($rows) => round((float) $rows->sum('amount'), 2)),
        ];

        return view('billing.admin.reports.index', compact('from', 'to', 'invoices', 'summary'));
    }

    public function insuranceClaims(Request $request)
    {
        $status = $request->input('status');

        $claims = InsuranceClaim::with('invoice.patient')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest('submitted_at')
            ->paginate(20);

        return view('billing.admin.insurance_claims.index', compact('claims', 'status'));
    }

    public function updateInsuranceClaim(Request $request, InsuranceClaim $claim)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,paid',
            'approved_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $claim->update([
            'status' => $validated['status'],
            'approved_amount' => $validated['approved_amount'] ?? $claim->approved_amount,
            'approved_at' => in_array($validated['status'], ['approved', 'paid']) ? now() : null,
            'notes' => $validated['notes'] ?? $claim->notes,
        ]);

        return back()->with('success', 'Insurance claim updated successfully.');
    }
}
