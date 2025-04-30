<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = \App\Models\Department::paginate(10);
        return view('Department.index', compact('departments'));
    }

    public function create()
    {
        return view('Department.create');
    }

    public function edit($id)
    {
        return view('Department.edit', compact('id'));
    }
    public function show($id)
    {
        return view('Department.show', compact('id'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        \App\Models\Department::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);
        return redirect()->route('department.index')->with('success', 'Department created successfully.');
    }
    public function destroy($id)
    {
        return view('Department.delete', compact('id'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $department = \App\Models\Department::findOrFail($id);
        $department->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);
        return redirect()->route('department.index')->with('success', 'Department updated successfully.');
    }
}
