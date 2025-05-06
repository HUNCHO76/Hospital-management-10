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
        'notes',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
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
}
