<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pretest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'nurse_id',
        'height',
        'weight',
        'blood_pressure',
        'temperature',
        'pulse_rate',
        'respiration_rate',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function nurse()
    {
        return $this->belongsTo(User::class);
    }
    public function doctorPatients()
    {
        return $this->hasMany(DoctorPatient::class);
    }
}
