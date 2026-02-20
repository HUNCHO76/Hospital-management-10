<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'diagnosis',
        'treatment',
        'notes',
        'vital_signs',
        'allergies',
        'chronic_conditions',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'vital_signs' => 'json',
        'allergies' => 'json',
        'chronic_conditions' => 'json',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function documents()
    {
        return $this->hasMany(PatientDocument::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
