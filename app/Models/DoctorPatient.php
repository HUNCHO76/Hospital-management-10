<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'pretest_id',
    ];
    public function doctors()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function pretest()
    {
        return $this->belongsTo(PreTest::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
