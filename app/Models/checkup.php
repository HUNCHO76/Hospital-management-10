<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkup extends Model
{
    use HasFactory;
    protected $fillable = [
        'pretest_id',
        'doctor_id',
        'disease',
        'status',
        'notes',
    ];
    
    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            Pretest::class,
            'id',           // Foreign key on pretests table
            'id',           // Foreign key on patients table
            'pretest_id',   // Local key on checkups table
            'patient_id'    // Local key on pretests table
        );
    }
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
    public function pretest()
    {
        return $this->belongsTo(Pretest::class);
    }
    public function doctorpatients()
    {
        return $this->hasMany(DoctorPatient::class);
    }

    public function sampleTestResult()
    {
        return $this->hasMany(SampleTestResult::class);
    }

    public function labOrders()
    {
        return $this->hasMany(LabOrder::class, 'checkup_id');
    }

    public function differentialDiagnoses()
    {
        return $this->hasMany(checkup_diseases::class, 'checkup_id');
    }
}
