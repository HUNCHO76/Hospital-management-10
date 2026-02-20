<?php

namespace App\Http\Controllers;

use App\Models\LabOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LabTechnicianLabOrderController extends Controller
{
    public function pendingOrders(Request $request)
    {
        $query = LabOrder::with(['patient', 'doctor.user', 'items'])
            ->where('status', 'pending')
            ->orderByDesc('order_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhereHas('patient', function ($patientQuery) use ($search) {
                        $patientQuery->where('full_name', 'like', '%' . $search . '%');
                    });
            });
        }

        $orders = $query->paginate(12)->withQueryString();

        return view('lab_orders.lab.pending', compact('orders'));
    }

    public function completedOrders(Request $request)
    {
        $query = LabOrder::with(['patient', 'doctor.user', 'items'])
            ->where('status', 'completed')
            ->orderByDesc('order_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhereHas('patient', function ($patientQuery) use ($search) {
                        $patientQuery->where('full_name', 'like', '%' . $search . '%');
                    });
            });
        }

        $orders = $query->paginate(12)->withQueryString();

        return view('lab_orders.lab.completed', compact('orders'));
    }

    public function enterResults($id)
    {
        $order = LabOrder::with(['patient', 'doctor.user', 'items.labTest', 'items.enteredBy'])->findOrFail($id);

        return view('lab_orders.lab.enter_results', compact('order'));
    }

    public function updateResults(Request $request, $id)
    {
        $order = LabOrder::with('items.labTest')->findOrFail($id);
        $action = $request->input('action', 'draft');

        $validated = $request->validate([
            'results' => 'nullable|array',
            'results.*' => 'nullable|string|max:255',
            'texts' => 'nullable|array',
            'texts.*' => 'nullable|string',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:1000',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        DB::transaction(function () use ($request, $validated, $order, $action) {
            foreach ($order->items as $item) {
                $itemId = $item->id;
                $resultValue = $validated['results'][$itemId] ?? null;
                $resultText = $validated['texts'][$itemId] ?? null;
                $notes = $validated['notes'][$itemId] ?? null;
                $hasFile = $request->hasFile("files.$itemId");

                if ($action === 'completed' && empty($resultValue) && empty($resultText) && !$hasFile) {
                    throw ValidationException::withMessages([
                        "results.$itemId" => "Please provide result data for {$item->labTest->test_name}.",
                    ]);
                }

                $filePath = $item->file_path;
                if ($hasFile) {
                    $filePath = $request->file("files.$itemId")->store('lab-results', 'public');
                }

                $hasAnyResult = !empty($resultValue) || !empty($resultText) || !empty($filePath);

                $item->update([
                    'result_value' => $resultValue,
                    'result_text' => $resultText,
                    'notes' => $notes,
                    'file_path' => $filePath,
                    'entered_by' => $hasAnyResult ? auth()->id() : $item->entered_by,
                    'entered_at' => $hasAnyResult ? now() : $item->entered_at,
                    'status' => $action === 'completed' ? 'completed' : ($hasAnyResult ? 'completed' : 'pending'),
                ]);
            }

            $hasPending = $order->items()->where('status', 'pending')->exists();
            $order->update(['status' => $hasPending ? 'pending' : 'completed']);
        });

        return redirect()->route('labtech.pending')->with('success', $action === 'completed' ? 'Lab results marked as completed.' : 'Lab results saved as draft.');
    }
}
