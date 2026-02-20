<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    public function index()
    {
        $labTests = LabTest::orderBy('category')->orderBy('test_name')->paginate(15);

        return view('lab_orders.admin.lab_tests.index', compact('labTests'));
    }

    public function create()
    {
        return view('lab_orders.admin.lab_tests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'reference_range' => 'nullable|string',
            'unit' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        LabTest::create($validated);

        return redirect()->route('admin.lab-tests.index')->with('success', 'Lab test created successfully.');
    }

    public function edit(LabTest $labTest)
    {
        return view('lab_orders.admin.lab_tests.edit', compact('labTest'));
    }

    public function update(Request $request, LabTest $labTest)
    {
        $validated = $request->validate([
            'test_name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'reference_range' => 'nullable|string',
            'unit' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        $labTest->update($validated);

        return redirect()->route('admin.lab-tests.index')->with('success', 'Lab test updated successfully.');
    }

    public function destroy(LabTest $labTest)
    {
        $labTest->delete();

        return redirect()->route('admin.lab-tests.index')->with('success', 'Lab test deleted successfully.');
    }
}
