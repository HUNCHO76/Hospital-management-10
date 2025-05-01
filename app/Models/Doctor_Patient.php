<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'pretest_id',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function pretest()
    {
        return $this->belongsTo(Pre_test::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
