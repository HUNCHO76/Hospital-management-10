<?php

namespace App\Models;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pre_test extends Model
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
        return $this->hasMany(Doctor_Patient::class);
    }
}
