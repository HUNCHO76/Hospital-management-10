<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'assigned_at',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function pretest()
    {
        return $this->hasOne(Pretest::class, 'patient_id', 'patient_id')->latest();
    }
}
