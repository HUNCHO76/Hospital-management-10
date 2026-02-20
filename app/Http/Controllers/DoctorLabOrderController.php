<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\LabOrder;
use App\Models\LabOrderItem;
use App\Models\LabTest;
use App\Models\Patient;
use App\Models\checkup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorLabOrderController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        $query = LabOrder::with(['patient', 'items'])
            ->where('doctor_id', $doctor->id)
            ->orderByDesc('order_date');

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('order_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('order_date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();
        $patients = Patient::orderBy('full_name')->get();

        return view('lab_orders.doctor.index', compact('orders', 'patients'));
    }

    public function create(Request $request, $checkupId = null)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        $labTests = LabTest::where('is_active', true)->orderBy('category')->orderBy('test_name')->get();
        $patients = Patient::orderBy('full_name')->get();

        $checkup = null;
        $selectedPatientId = $request->input('patient_id');

        if ($checkupId) {
            $checkup = checkup::with('pretest.patient')->findOrFail($checkupId);
            $selectedPatientId = $checkup->pretest?->patient_id ?? $selectedPatientId;
        }

        return view('lab_orders.doctor.create', compact('labTests', 'patients', 'checkup', 'selectedPatientId', 'doctor'));
    }

    public function store(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'checkup_id' => 'nullable|exists:checkups,id',
            'test_ids' => 'required|array|min:1',
            'test_ids.*' => 'required|exists:lab_tests,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($validated, $doctor) {
            $order = LabOrder::create([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $doctor->id,
                'checkup_id' => $validated['checkup_id'] ?? null,
                'order_date' => now(),
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['test_ids'] as $testId) {
                LabOrderItem::create([
                    'lab_order_id' => $order->id,
                    'lab_test_id' => $testId,
                    'status' => 'pending',
                ]);
            }
        });

        return redirect()->route('doctor.lab-orders.index')->with('success', 'Lab tests ordered successfully.');
    }

    public function show($id)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        $order = LabOrder::with(['patient', 'doctor.user', 'items.labTest', 'items.enteredBy'])
            ->where('doctor_id', $doctor->id)
            ->findOrFail($id);

        if ($order->status === 'completed' && !$order->viewed_at) {
            $order->update(['viewed_at' => now()]);
        }

        return view('lab_orders.doctor.show', compact('order'));
    }

    public function patientResults($patientId)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        $patient = Patient::findOrFail($patientId);

        $orders = LabOrder::with(['items.labTest', 'items.enteredBy'])
            ->where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->orderByDesc('order_date')
            ->get();

        return view('lab_orders.doctor.patient_results', compact('patient', 'orders'));
    }
}
