<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\BillingSetting;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InsuranceClaim;
use App\Models\LabOrder;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CashierBillingController extends Controller
{
    public function queue(Request $request)
    {
        $search = $request->input('search');
        $date = $request->input('date');

        $appointmentQueue = Appointment::with('patient')
            ->when($date, fn($query) => $query->whereDate('appointment_date', $date), fn($query) => $query->whereDate('appointment_date', Carbon::today()))
            ->when($search, function ($query) use ($search) {
                $query->whereHas('patient', fn($q) => $q->where('full_name', 'like', "%{$search}%"));
            })
            ->whereIn('status', ['scheduled', 'completed'])
            ->latest('appointment_date')
            ->get();

        $admissionQueue = Admission::with('patient')
            ->when($date, fn($query) => $query->whereDate('admission_date', $date))
            ->when($search, function ($query) use ($search) {
                $query->whereHas('patient', fn($q) => $q->where('full_name', 'like', "%{$search}%"));
            })
            ->latest('admission_date')
            ->take(50)
            ->get();

        $pendingInvoices = Invoice::with('patient')
            ->whereIn('status', ['pending', 'partially_paid'])
            ->latest('invoice_date')
            ->paginate(15);

        return view('billing.cashier.queue', compact('appointmentQueue', 'admissionQueue', 'pendingInvoices', 'search', 'date'));
    }

    public function create(?Patient $patient = null)
    {
        $patients = Patient::orderBy('full_name')->get();
        $settings = BillingSetting::current();

        $appointments = collect();
        $labOrders = collect();
        $admissions = collect();

        if ($patient) {
            $appointments = Appointment::where('patient_id', $patient->id)->latest('appointment_date')->take(10)->get();
            $labOrders = LabOrder::where('patient_id', $patient->id)->latest('order_date')->take(10)->get();
            $admissions = Admission::where('patient_id', $patient->id)->latest('admission_date')->take(10)->get();
        }

        return view('billing.cashier.invoices.create', compact('patients', 'patient', 'settings', 'appointments', 'labOrders', 'admissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'due_date' => 'nullable|date',
            'discount_type' => 'required|in:percentage,fixed,none',
            'discount_value' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:2000',
            'save_as' => 'required|in:draft,pending',
            'items' => 'required|array|min:1',
            'items.*.item_type' => 'required|string|max:50',
            'items.*.item_id' => 'nullable|integer|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $settings = BillingSetting::current();

        $invoice = DB::transaction(function () use ($validated, $settings) {
            $invoiceNumber = $this->generateInvoiceNumber($settings);

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'patient_id' => $validated['patient_id'],
                'cashier_id' => auth()->id(),
                'invoice_date' => now(),
                'due_date' => $validated['due_date'] ?? null,
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'] ?? 0,
                'tax_rate' => $validated['tax_rate'] ?? $settings->tax_rate,
                'notes' => $validated['notes'] ?? null,
                'status' => $validated['save_as'],
            ]);

            foreach ($validated['items'] as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_type' => $item['item_type'],
                    'item_id' => $item['item_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => round($item['quantity'] * $item['unit_price'], 2),
                ]);
            }

            $this->recalculateInvoiceTotals($invoice->fresh('items'));

            return $invoice;
        });

        return redirect()->route('cashier.invoices.show', $invoice->id)->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::with(['patient', 'cashier', 'items', 'payments.cashier', 'insuranceClaim'])->findOrFail($id);

        return view('billing.cashier.invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = Invoice::with(['patient', 'items'])->findOrFail($id);
        if (in_array($invoice->status, ['paid', 'cancelled', 'refunded'])) {
            return redirect()->route('cashier.invoices.show', $invoice->id)->with('error', 'This invoice can no longer be edited.');
        }

        $settings = BillingSetting::current();

        return view('billing.cashier.invoices.edit', compact('invoice', 'settings'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        if (in_array($invoice->status, ['paid', 'cancelled', 'refunded'])) {
            throw ValidationException::withMessages(['invoice' => 'This invoice can no longer be edited.']);
        }

        $validated = $request->validate([
            'due_date' => 'nullable|date',
            'discount_type' => 'required|in:percentage,fixed,none',
            'discount_value' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:2000',
            'status' => 'required|in:draft,pending,cancelled',
            'items' => 'required|array|min:1',
            'items.*.item_type' => 'required|string|max:50',
            'items.*.item_id' => 'nullable|integer|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($invoice, $validated) {
            $invoice->update([
                'due_date' => $validated['due_date'] ?? null,
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'] ?? 0,
                'tax_rate' => $validated['tax_rate'] ?? 0,
                'notes' => $validated['notes'] ?? null,
                'status' => $validated['status'],
            ]);

            $invoice->items()->delete();
            foreach ($validated['items'] as $item) {
                $invoice->items()->create([
                    'item_type' => $item['item_type'],
                    'item_id' => $item['item_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => round($item['quantity'] * $item['unit_price'], 2),
                ]);
            }

            $this->recalculateInvoiceTotals($invoice->fresh('items'));
        });

        return redirect()->route('cashier.invoices.show', $invoice->id)->with('success', 'Invoice updated successfully.');
    }

    public function paymentForm($id)
    {
        $invoice = Invoice::with('patient')->findOrFail($id);

        return view('billing.cashier.payments.create', compact('invoice'));
    }

    public function storePayment(Request $request, $id)
    {
        $invoice = Invoice::with('payments')->findOrFail($id);

        if (in_array($invoice->status, ['cancelled', 'refunded'])) {
            throw ValidationException::withMessages(['invoice' => 'Cannot receive payment for cancelled/refunded invoice.']);
        }

        $validated = $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,card,mobile_money,bank_transfer,insurance',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $balance = $invoice->balance;
        if ((float) $validated['amount'] > $balance) {
            throw ValidationException::withMessages([
                'amount' => 'Payment cannot be greater than outstanding balance.',
            ]);
        }

        DB::transaction(function () use ($invoice, $validated) {
            Payment::create([
                'invoice_id' => $invoice->id,
                'payment_date' => $validated['payment_date'],
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'reference_number' => $validated['reference_number'] ?? null,
                'cashier_id' => auth()->id(),
                'notes' => $validated['notes'] ?? null,
            ]);

            if ($validated['payment_method'] === 'insurance') {
                InsuranceClaim::updateOrCreate(
                    ['invoice_id' => $invoice->id],
                    [
                        'insurance_provider' => 'Not Specified',
                        'policy_number' => 'N/A',
                        'claim_number' => 'CLM-' . now()->format('Ymd') . '-' . str_pad((string) $invoice->id, 6, '0', STR_PAD_LEFT),
                        'total_claimed' => $invoice->total_amount,
                        'approved_amount' => $invoice->paid_amount + $validated['amount'],
                        'status' => 'pending',
                        'submitted_at' => now(),
                        'notes' => 'Auto-created from insurance payment entry.',
                    ]
                );
            }

            $invoice->paid_amount = $invoice->payments()->sum('amount');
            $invoice->refreshPaymentStatus();
        });

        return redirect()->route('cashier.invoices.show', $invoice->id)->with('success', 'Payment recorded successfully.');
    }

    public function print($id)
    {
        $invoice = Invoice::with(['patient', 'items', 'payments'])->findOrFail($id);

        return view('billing.cashier.invoices.print', compact('invoice'));
    }

    public function patientHistory(Patient $patient)
    {
        $invoices = Invoice::with('payments')
            ->where('patient_id', $patient->id)
            ->latest('invoice_date')
            ->paginate(20);

        return view('billing.cashier.patients.history', compact('patient', 'invoices'));
    }

    private function recalculateInvoiceTotals(Invoice $invoice): void
    {
        $subtotal = (float) $invoice->items->sum('total_price');
        $discountValue = (float) $invoice->discount_value;

        if ($invoice->discount_type === 'percentage') {
            $discountAmount = round($subtotal * ($discountValue / 100), 2);
        } elseif ($invoice->discount_type === 'fixed') {
            $discountAmount = min($subtotal, $discountValue);
        } else {
            $discountAmount = 0;
        }

        $taxable = max(0, $subtotal - $discountAmount);
        $taxAmount = round($taxable * (((float) $invoice->tax_rate) / 100), 2);
        $total = round($taxable + $taxAmount, 2);

        $invoice->subtotal = $subtotal;
        $invoice->discount_amount = $discountAmount;
        $invoice->tax_amount = $taxAmount;
        $invoice->total_amount = $total;

        if ($invoice->paid_amount > $total) {
            $invoice->paid_amount = $total;
        }

        $invoice->save();
        $invoice->refreshPaymentStatus();
    }

    private function generateInvoiceNumber(BillingSetting $settings): string
    {
        $number = str_pad((string) $settings->next_invoice_number, 4, '0', STR_PAD_LEFT);
        $invoiceNumber = sprintf('%s-%s-%s', $settings->invoice_prefix, now()->format('Ymd'), $number);

        $settings->increment('next_invoice_number');

        return $invoiceNumber;
    }
}
