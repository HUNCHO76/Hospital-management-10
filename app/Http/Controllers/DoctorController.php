<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::paginate(10);
        return view('Doctor.index', compact('doctors'));
    }

    public function create()
    {
        $users = User::get();
        $departments = Department::get();
        return view('Doctor.create', compact('users', 'departments'));
    }

    public function edit($id)
    {
        return view('Doctor.edit', compact('id'));
    }
    public function show($id)
    {
        return view('Doctor.show', compact('id'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'specialization' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        \App\Models\Doctor::create([
            'user_id' => $validatedData['user_id'],
            'specialization' => $validatedData['specialization'],
            'qualification' => $validatedData['qualification'],
            'department_id' => $validatedData['department_id'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);
        return redirect()->route('doctor.index')->with('success', 'Doctor created successfully.');
    }
    public function destroy($id)
    {
        return view('Doctor.delete', compact('id'));
    }
}
