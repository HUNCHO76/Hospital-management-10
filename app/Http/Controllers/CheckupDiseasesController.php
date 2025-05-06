<?php

namespace App\Http\Controllers;

use App\Models\checkup;
use App\Models\Disease;
use Illuminate\Http\Request;
use App\Models\checkup_diseases;

class CheckupDiseasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = checkup::orderBy('created_at', 'desc')
            ->get()
            ->unique('patient_id');
        return view('LabCheckUp.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Display the specified resource.
     */
    public function show(checkup_diseases $checkup_diseases, $id)
    {
        $checkups = checkup::find($id)->get();
        $patient = Checkup::find($id)->get();
        // dd($checkup);
        return view('LabCheckUp.show', compact('checkups', 'patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(checkup_diseases $checkup_diseases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, checkup_diseases $checkup_diseases)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(checkup_diseases $checkup_diseases)
    {
        //
    }
}
