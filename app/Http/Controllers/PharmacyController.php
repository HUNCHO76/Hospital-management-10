<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineInventory;
use App\Models\MedicineBatch;
use App\Models\MedicineOrder;
use App\Models\MedicineSupplier;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    /**
     * Display pharmacy dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_medicines' => Medicine::count(),
            'low_stock_items' => MedicineInventory::whereRaw('available_quantity <= minimum_stock_level')->count(),
            'expired_batches' => MedicineBatch::where('expiry_date', '<', now()->toDateString())->count(),
            'pending_orders' => MedicineOrder::where('status', 'pending')->count(),
        ];

        $recentOrders = MedicineOrder::latest()->take(10)->get();
        $expiringMedicines = MedicineBatch::where('expiry_date', '<=', now()->addMonth()->toDateString())
                                         ->where('expiry_date', '>', now()->toDateString())
                                         ->get();
        $lowStockItems = MedicineInventory::whereRaw('available_quantity <= minimum_stock_level')->get();

        return view('pharmacy.dashboard', compact('stats', 'recentOrders', 'expiringMedicines', 'lowStockItems'));
    }

    /**
     * View inventory
     */
    public function inventory(Request $request)
    {
        $query = Medicine::with(['inventory', 'manufacturer']);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('generic_name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'low_stock') {
                $query->whereHas('inventory', function ($q) {
                    $q->whereRaw('available_quantity <= minimum_stock_level');
                });
            } elseif ($request->status === 'out_of_stock') {
                $query->whereHas('inventory', function ($q) {
                    $q->where('available_quantity', 0);
                });
            }
        }

        $medicines = $query->paginate(15);

        return view('pharmacy.inventory', compact('medicines'));
    }

    /**
     * View medicine batches
     */
    public function batches(Request $request)
    {
        $query = MedicineBatch::with(['medicine', 'supplier']);

        if ($request->filled('medicine_id')) {
            $query->where('medicine_id', $request->medicine_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'expired') {
                $query->where('expiry_date', '<', now()->toDateString());
            } elseif ($request->status === 'expiring_soon') {
                $query->whereBetween('expiry_date', [now()->toDateString(), now()->addMonth()->toDateString()]);
            }
        }

        $batches = $query->orderBy('expiry_date', 'asc')->paginate(15);

        return view('pharmacy.batches', compact('batches'));
    }

    /**
     * View medicine orders
     */
    public function orders(Request $request)
    {
        $query = MedicineOrder::with(['supplier', 'items']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $orders = $query->orderBy('order_date', 'desc')->paginate(15);
        $suppliers = MedicineSupplier::where('is_active', true)->get();

        return view('pharmacy.orders', compact('orders', 'suppliers'));
    }

    /**
     * Create new medicine order
     */
    public function createOrder()
    {
        $suppliers = MedicineSupplier::where('is_active', true)->get();
        $medicines = Medicine::all();
        $lowStockItems = MedicineInventory::whereRaw('available_quantity <= minimum_stock_level')->get();

        return view('pharmacy.create-order', compact('suppliers', 'medicines', 'lowStockItems'));
    }

    /**
     * Store new medicine order
     */
    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:medicine_suppliers,id',
            'expected_delivery_date' => 'required|date|after:today',
            'items' => 'required|array',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        try {
            $order = MedicineOrder::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'supplier_id' => $validated['supplier_id'],
                'expected_delivery_date' => $validated['expected_delivery_date'],
                'status' => 'pending',
                'ordered_by' => auth()->id(),
                'notes' => $validated['notes'] ?? null,
                'order_date' => now(),
            ]);

            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $amount = $item['quantity'] * $item['unit_price'];
                $order->items()->create([
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_amount' => $amount,
                ]);
                $totalAmount += $amount;
            }

            $order->update(['total_amount' => $totalAmount]);

            return redirect()->route('pharmacy.orders')
                           ->with('success', 'Medicine order created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create order: ' . $e->getMessage()]);
        }
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, MedicineOrder $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,delivered,cancelled',
        ]);

        try {
            $order->update($validated);

            if ($validated['status'] === 'delivered') {
                $order->update(['actual_delivery_date' => now()->toDateString()]);
            }

            return redirect()->back()
                           ->with('success', 'Order status updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Receive medicine batch
     */
    public function receiveBatch(Request $request, $orderItemId)
    {
        $validated = $request->validate([
            'batch_number' => 'required|string',
            'quantity_received' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after:today',
            'manufacture_date' => 'nullable|date',
            'cost_price' => 'required|numeric|min:0.01',
        ]);

        try {
            $orderItem = \App\Models\MedicineOrderItem::findOrFail($orderItemId);

            // Create batch record
            $batch = MedicineBatch::create([
                'medicine_id' => $orderItem->medicine_id,
                'batch_number' => $validated['batch_number'],
                'expiry_date' => $validated['expiry_date'],
                'manufacture_date' => $validated['manufacture_date'] ?? null,
                'quantity_received' => $validated['quantity_received'],
                'quantity_available' => $validated['quantity_received'],
                'supplier_id' => $orderItem->medOrder->supplier_id,
                'cost_price' => $validated['cost_price'],
                'received_at' => now(),
            ]);

            // Update order item
            $orderItem->increment('received_quantity', $validated['quantity_received']);

            // Update inventory
            $inventory = MedicineInventory::firstOrCreate(
                ['medicine_id' => $orderItem->medicine_id],
                ['available_quantity' => 0]
            );
            $inventory->increment('available_quantity', $validated['quantity_received']);

            return redirect()->back()
                           ->with('success', 'Batch received and inventory updated!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Dispense medicine
     */
    public function dispenseMedicine(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'prescription_id' => 'nullable|exists:prescriptions,id',
        ]);

        try {
            $medicine = Medicine::findOrFail($validated['medicine_id']);
            $inventory = $medicine->inventory;

            if (!$inventory || $inventory->available_quantity < $validated['quantity']) {
                return back()->withErrors(['error' => 'Insufficient stock available']);
            }

            // Deduct from inventory
            $inventory->decrement('available_quantity', $validated['quantity']);

            return back()->with('success', 'Medicine dispensed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
